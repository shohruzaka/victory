<?php

namespace App\Livewire\Student\Arena;

use App\Models\GameResult;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class Survival extends Component
{
    public $instanceId;

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

    public $selectedSubjectId = null;

    public $selectedTopicId = null;

    public function mount()
    {
        $this->selectedSubjectId = request('subject_id');
        $this->selectedTopicId = request('topic_id');

        $cacheKey = 'arena_survival_' . auth()->id();
        $cached = Cache::get($cacheKey);

        if ($cached && 
            $cached['subject_id'] == $this->selectedSubjectId && 
            $cached['topic_id'] == $this->selectedTopicId &&
            !$cached['isFinished']) {
            
            $this->questionIds = $cached['questionIds'];
            $this->currentIndex = $cached['currentIndex'];
            $this->score = $cached['score'];
            $this->xpEarned = $cached['xpEarned'];
            $this->showResult = $cached['showResult'] ?? false;
            $this->selectedOptionId = $cached['selectedOptionId'] ?? null;
            $this->isCorrect = $cached['isCorrect'] ?? null;
            $this->correctOptionId = $cached['correctOptionId'] ?? null;
            $this->reasonForFinish = $cached['reasonForFinish'] ?? '';
            
            // Xavfsizlik: Eski oynani yaroqsiz qilish uchun yangi ID generatsiya qilamiz
            $this->instanceId = (string) Str::uuid();
            $this->saveToCache();
        } else {
            $this->instanceId = (string) Str::uuid();
            $query = Question::query();

            if ($this->selectedSubjectId) {
                $query->whereHas('topic', function ($q) {
                    $q->where('subject_id', $this->selectedSubjectId);
                });
            }

            if ($this->selectedTopicId) {
                $query->where('topic_id', $this->selectedTopicId);
            }

            $this->questionIds = $query->inRandomOrder()->pluck('id')->toArray();

            if (empty($this->questionIds)) {
                $this->isFinished = true;
                $this->reasonForFinish = 'no_questions';
            } else {
                $this->saveToCache();
            }
        }
    }

    protected function validateSession()
    {
        $cached = Cache::get('arena_survival_' . auth()->id());
        
        if ($cached && isset($cached['instanceId']) && $cached['instanceId'] !== $this->instanceId) {
            $this->dispatch('swal', [
                'title' => 'Sessiya eskirgan!',
                'text' => 'Boshqa oynada test faollashgan. Davom etish uchun sahifani yangilang.',
                'icon' => 'warning'
            ]);
            return false;
        }
        
        return true;
    }

    public function getQuestionProperty()
    {
        if (! isset($this->questionIds[$this->currentIndex])) {
            return null;
        }

        return Question::with('options')->find($this->questionIds[$this->currentIndex]);
    }

    public function answer($optionId)
    {
        if (!$this->validateSession()) {
            return;
        }

        if ($this->showResult || $this->isFinished) {
            return;
        }

        $this->selectedOptionId = $optionId;
        $question = $this->question;

        // Statistika: Umumiy urinishlarni oshiramiz
        $question->increment('total_attempts');

        $correctOption = $question->options->where('is_correct', true)->first();
        $this->correctOptionId = $correctOption ? $correctOption->id : null;

        if ($this->correctOptionId == $optionId) {
            $this->isCorrect = true;
            $this->score++;

            // Statistika: To'g'ri javoblar urinishini oshiramiz
            $question->increment('correct_attempts');
            
            // Progressive XP: Har bir keyingi savol uchun +10 XP bonus
            $bonus = $this->currentIndex * 10;
            $this->xpEarned += ($question->points + $bonus);
            
            $this->showResult = true;
        } else {
            // One mistake ends the run!
            $this->isCorrect = false;
            $this->showResult = true;
            $this->reasonForFinish = 'mistake';
            // We'll show the correct answer first, then end
        }

        $this->saveToCache();
    }

    public function proceed()
    {
        if (!$this->validateSession()) {
            return;
        }

        if ($this->reasonForFinish === 'mistake') {
            $this->finishGame();

            return;
        }

        $this->currentIndex++;
        $this->showResult = false;
        $this->selectedOptionId = null;
        $this->isCorrect = null;
        $this->correctOptionId = null;

        if ($this->currentIndex >= count($this->questionIds)) {
            $this->reasonForFinish = 'no_questions';
            $this->finishGame();
        } else {
            $this->saveToCache();
        }
    }

    protected function saveToCache()
    {
        Cache::put('arena_survival_' . auth()->id(), [
            'instanceId' => $this->instanceId,
            'questionIds' => $this->questionIds,
            'currentIndex' => $this->currentIndex,
            'score' => $this->score,
            'xpEarned' => $this->xpEarned,
            'subject_id' => $this->selectedSubjectId,
            'topic_id' => $this->selectedTopicId,
            'showResult' => $this->showResult,
            'selectedOptionId' => $this->selectedOptionId,
            'isCorrect' => $this->isCorrect,
            'correctOptionId' => $this->correctOptionId,
            'reasonForFinish' => $this->reasonForFinish,
            'isFinished' => $this->isFinished,
        ], now()->addHours(2));
    }

    protected function finishGame()
    {
        $this->isFinished = true;
        Cache::forget('arena_survival_' . auth()->id());
        $user = auth()->user();

        // Get subject name for category
        $categoryName = 'Neural Matrix';
        if ($this->selectedSubjectId) {
            $subject = Subject::find($this->selectedSubjectId);
            if ($subject) {
                $categoryName = $subject->name;
            }
        }

        // Save result
        GameResult::create([
            'user_id' => $user->id,
            'mode' => 'survival',
            'category' => $categoryName,
            'score' => $this->score,
            'total_questions' => $this->currentIndex + 1,
            'xp_earned' => $this->xpEarned,
        ]);

        $user->increment('xp', $this->xpEarned);
        $newLevel = floor($user->xp / 1000) + 1;
        if ($newLevel > $user->level) {
            $user->level = $newLevel;
            $user->save();
            $user->notify(new \App\Notifications\LevelUpNotification($newLevel));
        }

        // Check for achievements
        \App\Services\AchievementService::check($user);
    }

    public function render()
    {
        $question = $this->question;
        
        return view('livewire.student.arena.survival', [
            'currentQuestion' => $question,
            'currentOptions' => $question ? $question->options : []
        ])->layout('components.layouts.student');
    }
}
