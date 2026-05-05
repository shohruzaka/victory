<?php

namespace App\Livewire\Student\Arena;

use App\Events\DuelUpdated;
use App\Models\Duel;
use App\Models\Question;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class DuelGame extends Component
{
    public Duel $duel;
    public $instanceId;
    public $currentIndex = 0;
    public $score = 0;
    public $isFinished = false;
    
    public $opponentScore = 0;
    public $opponentIndex = 0;
    
    public $selectedOptionId = null;
    public $showResult = false;
    public $isCorrect = null;
    public $correctOptionId = null;

    public $currentQuestion = null;
    public $currentOptions = [];

    public function mount($uuid)
    {
        $this->duel = Duel::where('uuid', $uuid)->firstOrFail();
        
        // Multi-tab himoyasi
        $this->instanceId = (string) \Illuminate\Support\Str::uuid();
        \Illuminate\Support\Facades\Cache::put('duel_instance_' . $this->duel->id . '_' . auth()->id(), $this->instanceId, now()->addHours(1));

        // Kim p1 va kim p2 ekanligini aniqlash
        if (auth()->id() == $this->duel->player1_id) {
            $this->score = $this->duel->p1_score;
            $this->currentIndex = $this->duel->p1_current_index;
            $this->opponentScore = $this->duel->p2_score;
            $this->opponentIndex = $this->duel->p2_current_index;
        } else {
            $this->score = $this->duel->p2_score;
            $this->currentIndex = $this->duel->p2_current_index;
            $this->opponentScore = $this->duel->p1_score;
            $this->opponentIndex = $this->duel->p1_current_index;
        }

        $this->loadQuestion();
    }

    public function loadQuestion()
    {
        $questionIds = $this->duel->question_ids;
        if (!isset($questionIds[$this->currentIndex])) {
            $this->currentQuestion = null;
            $this->currentOptions = [];
            return;
        }

        $this->currentQuestion = Question::with('options')->find($questionIds[$this->currentIndex]);
        if ($this->currentQuestion) {
            $this->currentOptions = $this->currentQuestion->options->shuffle()->toArray();
        }
    }

    protected function validateSession()
    {
        $cachedId = \Illuminate\Support\Facades\Cache::get('duel_instance_' . $this->duel->id . '_' . auth()->id());
        
        if ($cachedId && $cachedId !== $this->instanceId) {
            $this->dispatch('swal', [
                'title' => 'Sessiya eskirgan!',
                'text' => 'Ushbu duel boshqa oynada faollashgan.',
                'icon' => 'warning'
            ]);
            return false;
        }
        
        return true;
    }

    public function answer($optionId)
    {
        if (!$this->validateSession()) return;
        if ($this->showResult || $this->isFinished) return;

        $this->selectedOptionId = $optionId;
        
        // Statistika: Umumiy urinishlarni oshiramiz
        $this->currentQuestion->increment('total_attempts');
        
        $correctOption = collect($this->currentOptions)->where('is_correct', true)->first();
        $this->correctOptionId = $correctOption ? $correctOption['id'] : null;

        if ($this->correctOptionId == $optionId) {
            $this->isCorrect = true;
            $this->score++;

            // Statistika: To'g'ri javoblar urinishini oshiramiz
            $this->currentQuestion->increment('correct_attempts');
        } else {
            $this->isCorrect = false;
        }

        $this->showResult = true;

        // Bazani yangilash
        if (auth()->id() == $this->duel->player1_id) {
            $this->duel->update(['p1_score' => $this->score]);
        } else {
            $this->duel->update(['p2_score' => $this->score]);
        }

        broadcast(new DuelUpdated($this->duel));
    }

    public function nextQuestion()
    {
        if (!$this->validateSession()) return;

        $this->currentIndex++;
        $this->showResult = false;
        $this->selectedOptionId = null;

        // Progressni yangilash
        if (auth()->id() == $this->duel->player1_id) {
            $this->duel->update(['p1_current_index' => $this->currentIndex]);
        } else {
            $this->duel->update(['p2_current_index' => $this->currentIndex]);
        }

        broadcast(new DuelUpdated($this->duel));

        if ($this->currentIndex >= count($this->duel->question_ids)) {
            $this->checkFinish();
        } else {
            $this->loadQuestion();
        }
    }

    protected function checkFinish()
    {
        $this->isFinished = true;
        
        // Ikkala o'yinchi ham tugatganini tekshirish
        $duel = $this->duel->fresh();
        if ($duel->p1_current_index >= count($duel->question_ids) && $duel->p2_current_index >= count($duel->question_ids)) {
            
            $winnerId = null;
            if ($duel->p1_score > $duel->p2_score) $winnerId = $duel->player1_id;
            elseif ($duel->p2_score > $duel->p1_score) $winnerId = $duel->player2_id;

            $duel->update([
                'status' => 'finished',
                'winner_id' => $winnerId
            ]);

            // XP berish va xabarnoma yuborish
            if ($winnerId) {
                $winner = User::find($winnerId);
                $winner->increment('xp', 200); // G'olibga 200 XP
                $winner->notify(new \App\Notifications\DuelFinishedNotification($duel, 'victory'));
                \App\Services\AchievementService::check($winner);

                $loserId = ($winnerId == $duel->player1_id) ? $duel->player2_id : $duel->player1_id;
                if ($loserId) {
                    $loser = User::find($loserId);
                    $loser->notify(new \App\Notifications\DuelFinishedNotification($duel, 'defeat'));
                    \App\Services\AchievementService::check($loser);
                }
            } else {
                // Durang (Draw)
                $p1 = User::find($duel->player1_id);
                $p2 = User::find($duel->player2_id);
                $p1->notify(new \App\Notifications\DuelFinishedNotification($duel, 'draw'));
                $p2->notify(new \App\Notifications\DuelFinishedNotification($duel, 'draw'));
                \App\Services\AchievementService::check($p1);
                \App\Services\AchievementService::check($p2);
            }

            broadcast(new DuelUpdated($duel));
        }
    }

    public function getListeners()
    {
        return [
            "echo-private:duel.{$this->duel->uuid},DuelUpdated" => 'onDuelUpdated',
        ];
    }

    public function onDuelUpdated($data)
    {
        // Raqibdan kelgan ma'lumotlarni yuklaymiz
        $duelData = $data['duel'];
        
        if (auth()->id() == $duelData['player1_id']) {
            $this->opponentScore = $duelData['p2_score'];
            $this->opponentIndex = $duelData['p2_current_index'];
        } else {
            $this->opponentScore = $duelData['p1_score'];
            $this->opponentIndex = $duelData['p1_current_index'];
        }

        // Agar duel tugagan bo'lsa (baza orqali tekshiramiz)
        if (isset($duelData['status']) && $duelData['status'] === 'finished') {
            $this->duel->refresh();
            $this->isFinished = true;
        }
    }

    public function render()
    {
        return view('livewire.student.arena.duel-game', [
            'opponent' => auth()->id() == $this->duel->player1_id ? $this->duel->player2 : $this->duel->player1
        ])->layout('components.layouts.student');
    }
}
