<?php

namespace App\Livewire\Student\Arena;

use App\Models\GameResult;
use App\Models\Question;
use Livewire\Component;

class Survival extends Component
{
    public $questionIds = [];
    public $currentIndex = 0;
    public $score = 0;
    public $xpEarned = 0;
    public $isFinished = false;
    public $reasonForFinish = ''; // "mistake" or "no_questions"
    
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

        $this->questionIds = $query->inRandomOrder()->pluck('id')->toArray();
        
        if (empty($this->questionIds)) {
            $this->isFinished = true;
            $this->reasonForFinish = 'no_questions';
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
        if ($this->showResult || $this->isFinished) return;

        $this->selectedOptionId = $optionId;
        $question = $this->question;
        $correctOption = $question->options->where('is_correct', true)->first();
        $this->correctOptionId = $correctOption ? $correctOption->id : null;

        if ($this->correctOptionId == $optionId) {
            $this->isCorrect = true;
            $this->score++;
            $this->xpEarned += $question->points;
            $this->showResult = true;
        } else {
            // One mistake ends the run!
            $this->isCorrect = false;
            $this->showResult = true;
            $this->reasonForFinish = 'mistake';
            // We'll show the correct answer first, then end
        }
    }

    public function proceed()
    {
        if ($this->reasonForFinish === 'mistake') {
            $this->finishGame();
            return;
        }

        $this->currentIndex++;
        $this->showResult = false;
        $this->selectedOptionId = null;

        if ($this->currentIndex >= count($this->questionIds)) {
            $this->reasonForFinish = 'no_questions';
            $this->finishGame();
        }
    }

    protected function finishGame()
    {
        $this->isFinished = true;
        $user = auth()->user();

        // Save result
        GameResult::create([
            'user_id' => $user->id,
            'mode' => 'survival',
            'score' => $this->score,
            'total_questions' => $this->currentIndex + 1,
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
        return view('livewire.student.arena.survival')
            ->layout('components.layouts.student');
    }
}
