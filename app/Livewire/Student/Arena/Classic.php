<?php

namespace App\Livewire\Student\Arena;

use App\Models\GameResult;
use App\Models\Question;
use Livewire\Component;

class Classic extends Component
{
    public $questionIds = [];
    public $currentIndex = 0;
    public $score = 0;
    public $xpEarned = 0;
    public $isFinished = false;
    
    public $selectedOptionId = null;
    public $isCorrect = null;
    public $correctOptionId = null;
    public $showResult = false;

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

    public function answer($optionId)
    {
        if ($this->showResult) return; // Prevent double answering

        $this->selectedOptionId = $optionId;
        
        $question = $this->question;
        $correctOption = $question->options->where('is_correct', true)->first();
        $this->correctOptionId = $correctOption ? $correctOption->id : null;

        if ($this->correctOptionId == $optionId) {
            $this->isCorrect = true;
            $this->score++;
            $this->xpEarned += $question->points;
        } else {
            $this->isCorrect = false;
        }

        $this->showResult = true;
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
        }
    }

    protected function finishGame()
    {
        $this->isFinished = true;
        $user = auth()->user();

        // Save game result
        GameResult::create([
            'user_id' => $user->id,
            'mode' => 'classic',
            'score' => $this->score,
            'total_questions' => count($this->questionIds),
            'xp_earned' => $this->xpEarned,
        ]);

        // Add XP to user
        $user->increment('xp', $this->xpEarned);
        
        // Recalculate level (simple logic: 1000 XP per level)
        $newLevel = floor($user->xp / 1000) + 1;
        if ($newLevel > $user->level) {
            $user->level = $newLevel;
            $user->save();
        }
    }

    public function render()
    {
        return view('livewire.student.arena.classic')
            ->layout('components.layouts.student');
    }
}
