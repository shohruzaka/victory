<?php

namespace App\Livewire\Student\Arena;

use App\Models\GameResult;
use App\Models\Question;
use Livewire\Component;

class SpeedRun extends Component
{
    public $questionIds = [];
    public $currentIndex = 0;
    public $score = 0;
    public $xpEarned = 0;
    public $bonusXp = 0;
    public $isFinished = false;
    
    public $selectedOptionId = null;
    public $isCorrect = null;
    public $correctOptionId = null;
    public $showResult = false;
    public $timePerQuestion = 15; // 15 seconds per question

    public $selectedSubjectId = null;
    public $selectedTopicId = null;

    public $currentQuestion = null;
    public $currentOptions = [];

    public function mount()
    {
        $this->selectedSubjectId = request('subject_id');
        $this->selectedTopicId = request('topic_id');

        $query = Question::query();

        if ($this->selectedSubjectId) {
            $query->whereHas('topic', function($q) {
                $q->where('subject_id', $this->selectedSubjectId);
            });
        }

        if ($this->selectedTopicId) {
            $query->where('topic_id', $this->selectedTopicId);
        }

        $this->questionIds = $query->inRandomOrder()->limit(10)->pluck('id')->toArray();
        
        if (empty($this->questionIds)) {
            $this->isFinished = true;
        } else {
            $this->loadQuestion();
        }
    }

    public function loadQuestion()
    {
        $questionId = $this->questionIds[$this->currentIndex];
        $this->currentQuestion = Question::with('options')->find($questionId);
        $this->currentOptions = $this->currentQuestion->options->shuffle()->toArray();
    }

    public function answer($optionId, $timeLeft = 0)
    {
        if ($this->showResult || $this->isFinished) return;

        $this->selectedOptionId = $optionId;
        
        $correctOption = collect($this->currentOptions)->where('is_correct', true)->first();
        $this->correctOptionId = $correctOption ? $correctOption['id'] : null;

        if ($optionId && $this->correctOptionId == $optionId) {
            $this->isCorrect = true;
            $this->score++;
            
            // Base XP
            $earned = $this->currentQuestion->points;
            
            // Speed Bonus: 1 XP for every remaining second
            $bonus = (int) $timeLeft;
            $this->bonusXp += $bonus;
            $this->xpEarned += ($earned + $bonus);
        } else {
            $this->isCorrect = false;
        }

        $this->showResult = true;
        
        // Auto-advance after 1.5 seconds in Speed Run mode for faster flow
        $this->dispatch('start-next-timer');
    }

    public function timeout()
    {
        if ($this->showResult || $this->isFinished) return;
        $this->answer(null, 0); // Trigger wrong answer on timeout
    }

    public function nextQuestion()
    {
        $this->currentIndex++;
        $this->showResult = false;
        $this->selectedOptionId = null;
        $this->isCorrect = null;
        $this->correctOptionId = null;

        if ($this->currentIndex >= count($this->questionIds)) {
            $this->finishGame();
        } else {
            $this->loadQuestion();
            $this->dispatch('reset-timer');
        }
    }

    protected function finishGame()
    {
        $this->isFinished = true;
        $user = auth()->user();

        GameResult::create([
            'user_id' => $user->id,
            'mode' => 'speedrun',
            'score' => $this->score,
            'total_questions' => count($this->questionIds),
            'xp_earned' => $this->xpEarned,
        ]);

        $user->increment('xp', $this->xpEarned);
        $newLevel = floor($user->xp / 1000) + 1;
        if ($newLevel > $user->level) {
            $user->level = $newLevel;
            $user->save();
        }
    }

    public function render()
    {
        return view('livewire.student.arena.speed-run')
            ->layout('components.layouts.student');
    }
}
