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
    public $currentIndex = 0;
    public $score = 0;
    public $isFinished = false;
    
    public $opponentScore = 0;
    public $opponentIndex = 0;
    
    public $selectedOptionId = null;
    public $showResult = false;
    public $isCorrect = null;
    public $correctOptionId = null;

    public function mount($uuid)
    {
        $this->duel = Duel::where('uuid', $uuid)->firstOrFail();
        
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
    }

    public function getListeners()
    {
        return [
            "echo-private:duel.{$this->duel->uuid},DuelUpdated" => 'onDuelUpdated',
        ];
    }

    public function onDuelUpdated($data)
    {
        $updatedDuel = Duel::find($data['duel']['id']);
        
        if (auth()->id() == $updatedDuel->player1_id) {
            $this->opponentScore = $updatedDuel->p2_score;
            $this->opponentIndex = $updatedDuel->p2_current_index;
        } else {
            $this->opponentScore = $updatedDuel->p1_score;
            $this->opponentIndex = $updatedDuel->p1_current_index;
        }

        if ($updatedDuel->status === 'finished') {
            $this->duel = $updatedDuel;
            $this->isFinished = true;
        }
    }

    public function getQuestionProperty()
    {
        $questionIds = $this->duel->question_ids;
        if (!isset($questionIds[$this->currentIndex])) return null;

        return Question::with('options')->find($questionIds[$this->currentIndex]);
    }

    public function answer($optionId)
    {
        if ($this->showResult || $this->isFinished) return;

        $this->selectedOptionId = $optionId;
        $question = $this->question;
        $correctOption = $question->options->where('is_correct', true)->first();
        $this->correctOptionId = $correctOption ? $correctOption->id : null;

        if ($this->correctOptionId == $optionId) {
            $this->isCorrect = true;
            $this->score++;
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

            // XP berish
            if ($winnerId) {
                User::find($winnerId)->increment('xp', 200); // G'olibga 200 XP
            }
            
            broadcast(new DuelUpdated($duel));
        }
    }

    public function render()
    {
        return view('livewire.student.arena.duel-game', [
            'opponent' => auth()->id() == $this->duel->player1_id ? $this->duel->player2 : $this->duel->player1
        ])->layout('components.layouts.student');
    }
}
