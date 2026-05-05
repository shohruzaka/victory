<?php

namespace App\Livewire\Student\Arena;

use App\Models\GameResult;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class SpeedRun extends Component
{
    public $instanceId;

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

    public $timePerQuestion = 15;

    public $selectedSubjectId = null;

    public $selectedTopicId = null;

    public $currentQuestion = null;

    public $currentOptions = [];

    public function mount()
    {
        $this->selectedSubjectId = request('subject_id');
        $this->selectedTopicId = request('topic_id');

        $cacheKey = 'arena_speedrun_' . auth()->id();
        $cached = Cache::get($cacheKey);

        if ($cached && 
            $cached['subject_id'] == $this->selectedSubjectId && 
            $cached['topic_id'] == $this->selectedTopicId &&
            $cached['currentIndex'] < count($cached['questionIds'])) {
            
            $this->questionIds = $cached['questionIds'];
            $this->currentIndex = $cached['currentIndex'];
            $this->score = $cached['score'];
            $this->xpEarned = $cached['xpEarned'];
            $this->bonusXp = $cached['bonusXp'] ?? 0;
            $this->showResult = $cached['showResult'] ?? false;
            $this->selectedOptionId = $cached['selectedOptionId'] ?? null;
            $this->isCorrect = $cached['isCorrect'] ?? null;
            $this->correctOptionId = $cached['correctOptionId'] ?? null;
            
            $this->instanceId = (string) Str::uuid();
            $this->timePerQuestion = Cache::get('setting_speedrun_time', 15);
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

            $limit = Cache::get('setting_speedrun_limit', 10);
            $this->timePerQuestion = Cache::get('setting_speedrun_time', 15);
            $this->questionIds = $query->inRandomOrder()->limit($limit)->pluck('id')->toArray();

            if (!empty($this->questionIds)) {
                $this->saveToCache();
            }
        }

        if (empty($this->questionIds)) {
            $this->isFinished = true;
        } else {
            $this->loadQuestion();
        }
    }

    protected function validateSession()
    {
        $cached = Cache::get('arena_speedrun_' . auth()->id());
        
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

    public function loadQuestion()
    {
        $questionId = $this->questionIds[$this->currentIndex];
        $this->currentQuestion = Question::with('options')->find($questionId);
        $this->currentOptions = $this->currentQuestion->options->shuffle()->toArray();
    }

    public function answer($optionId, $timeLeft = 0)
    {
        if (!$this->validateSession()) {
            return;
        }

        if ($this->showResult || $this->isFinished) {
            return;
        }

        $this->selectedOptionId = $optionId;

        // Statistika: Umumiy urinishlarni oshiramiz
        $this->currentQuestion->increment('total_attempts');

        $correctOption = collect($this->currentOptions)->where('is_correct', true)->first();
        $this->correctOptionId = $correctOption ? $correctOption['id'] : null;

        if ($optionId && $this->correctOptionId == $optionId) {
            $this->isCorrect = true;
            $this->score++;

            // Statistika: To'g'ri javoblar urinishini oshiramiz
            $this->currentQuestion->increment('correct_attempts');

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
        $this->saveToCache();

        // Auto-advance after 1.5 seconds in Speed Run mode for faster flow
        $this->dispatch('start-next-timer');
    }

    public function timeout()
    {
        if (!$this->validateSession()) {
            return;
        }

        if ($this->showResult || $this->isFinished) {
            return;
        }
        $this->answer(null, 0); // Trigger wrong answer on timeout
    }

    public function nextQuestion()
    {
        if (!$this->validateSession()) {
            return;
        }

        $this->currentIndex++;
        $this->showResult = false;
        $this->selectedOptionId = null;
        $this->isCorrect = null;
        $this->correctOptionId = null;

        if ($this->currentIndex >= count($this->questionIds)) {
            $this->finishGame();
        } else {
            $this->loadQuestion();
            $this->saveToCache();
            $this->dispatch('reset-timer');
        }
    }

    protected function saveToCache()
    {
        Cache::put('arena_speedrun_' . auth()->id(), [
            'instanceId' => $this->instanceId,
            'questionIds' => $this->questionIds,
            'currentIndex' => $this->currentIndex,
            'score' => $this->score,
            'xpEarned' => $this->xpEarned,
            'bonusXp' => $this->bonusXp,
            'subject_id' => $this->selectedSubjectId,
            'topic_id' => $this->selectedTopicId,
            'showResult' => $this->showResult,
            'selectedOptionId' => $this->selectedOptionId,
            'isCorrect' => $this->isCorrect,
            'correctOptionId' => $this->correctOptionId,
        ], now()->addHours(2));
    }

    protected function finishGame()
    {
        $this->isFinished = true;
        Cache::forget('arena_speedrun_' . auth()->id());
        $user = auth()->user();

        // Get subject name for category
        $categoryName = 'Neural Matrix';
        if ($this->selectedSubjectId) {
            $subject = Subject::find($this->selectedSubjectId);
            if ($subject) {
                $categoryName = $subject->name;
            }
        }

        GameResult::create([
            'user_id' => $user->id,
            'mode' => 'speedrun',
            'category' => $categoryName,
            'score' => $this->score,
            'total_questions' => count($this->questionIds),
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
        return view('livewire.student.arena.speed-run')
            ->layout('components.layouts.student');
    }
}
