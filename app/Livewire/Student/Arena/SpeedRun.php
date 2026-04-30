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

    public $selectedSubject = null;
    public $selectedTopic = null;

    public function mount()
    {
        $this->selectedSubject = request('subject');
        $this->selectedTopic = request('topic');

        $query = Question::query();

        if ($this->selectedSubject) {
            $query->where('subject', $this->selectedSubject);
        }

        if ($this->selectedTopic) {
            $query->where('topic', $this->selectedTopic);
        }

        $this->questionIds = $query->inRandomOrder()->limit(10)->pluck('id')->toArray();
        
        if (empty($this->questionIds)) {
            $this->isFinished = true;
        }
    }

    public function getQuestionProperty()
    {
        if (!isset($this->questionIds[$this->currentIndex])) {
            return null;
        }

        return Question::with('options')->find($this->questionIds[$this->currentIndex]);
    }

    public function answer($optionId, $timeLeft = 0)
    {
        if ($this->showResult || $this->isFinished) return;

        $this->selectedOptionId = $optionId;
        $question = $this->question;
        $correctOption = $question->options->where('is_correct', true)->first();
        $this->correctOptionId = $correctOption ? $correctOption->id : null;

        if ($optionId && $this->correctOptionId == $optionId) {
            $this->isCorrect = true;
            $this->score++;
            
            // Base XP
            $earned = $question->points;
            
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
