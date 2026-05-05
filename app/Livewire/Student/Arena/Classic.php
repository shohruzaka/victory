<?php

namespace App\Livewire\Student\Arena;

use App\Models\GameResult;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class Classic extends Component
{
    public $instanceId;

    public $questionIds = [];

    public $currentIndex = 0;

    public $score = 0;

    public $xpEarned = 0;

    public $isFinished = false;

    public $selectedOptionId = null;

    public $isCorrect = null;

    public $correctOptionId = null;

    public $showResult = false;

    public $selectedSubjectId = null;

    public $selectedTopicId = null;

    public $currentQuestion = null;

    public $currentOptions = [];

    public function mount()
    {
        $this->selectedSubjectId = request('subject_id');
        $this->selectedTopicId = request('topic_id');

        $cacheKey = 'arena_classic_' . auth()->id();
        $cached = Cache::get($cacheKey);

        if ($cached && 
            $cached['subject_id'] == $this->selectedSubjectId && 
            $cached['topic_id'] == $this->selectedTopicId &&
            $cached['currentIndex'] < count($cached['questionIds'])) {
            
            $this->questionIds = $cached['questionIds'];
            $this->currentIndex = $cached['currentIndex'];
            $this->score = $cached['score'];
            $this->xpEarned = $cached['xpEarned'];
            $this->showResult = $cached['showResult'] ?? false;
            $this->selectedOptionId = $cached['selectedOptionId'] ?? null;
            $this->isCorrect = $cached['isCorrect'] ?? null;
            $this->correctOptionId = $cached['correctOptionId'] ?? null;
            
            // Xavfsizlik: Har bir yangi kirish/refresh yangi ID bilan tamg'alanadi
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

            $limit = \Illuminate\Support\Facades\Cache::get('setting_classic_limit', 10);
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
        $cached = Cache::get('arena_classic_' . auth()->id());
        
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
        
        $question = Question::with('topic.subject')->find($questionId);
        
        // Savol obyektini massivga o'girmiz va faqat kerakli ma'lumotlarni olamiz (Xavfsizlik uchun)
        $this->currentQuestion = [
            'id' => $question->id,
            'text' => $question->text,
            'category' => $question->topic->subject->name ?? 'Neural_Matrix',
            'points' => $question->points,
        ];

        // Variantlarni filtrlash: is_correct va boshqa sirlarni o'chiramiz
        $this->currentOptions = $question->options->shuffle()->map(function ($option) {
            return [
                'id' => $option->id,
                'text' => $option->text,
            ];
        })->toArray();
    }

    public function answer($optionId)
    {
        if (!$this->validateSession()) {
            return;
        }

        if ($this->showResult) {
            return;
        } // Prevent double answering

        $this->selectedOptionId = $optionId;

        // XAVFSIZLIK: To'g'ri javobni mijoz yuborgan arraydan emas, to'g'ridan-to'g'ri bazadan so'raymiz
        $questionId = $this->questionIds[$this->currentIndex];
        
        // Statistika: Umumiy urinishlarni oshiramiz
        Question::where('id', $questionId)->increment('total_attempts');

        $correctOption = \App\Models\Option::where('question_id', $questionId)
                                            ->where('is_correct', true)
                                            ->first();

        $this->correctOptionId = $correctOption ? $correctOption->id : null;

        if ($this->correctOptionId == $optionId) {
            $this->isCorrect = true;
            $this->score++;
            $this->xpEarned += $this->currentQuestion['points'] ?? 10;
            
            // Statistika: To'g'ri javoblar urinishini oshiramiz
            Question::where('id', $questionId)->increment('correct_attempts');
        } else {
            $this->isCorrect = false;
        }

        $this->showResult = true;
        $this->saveToCache();
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
        }
    }

    protected function saveToCache()
    {
        Cache::put('arena_classic_' . auth()->id(), [
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
        ], now()->addHours(2));
    }

    protected function finishGame()
    {
        $this->isFinished = true;
        Cache::forget('arena_classic_' . auth()->id());
        $user = auth()->user();


        // Get subject name for category
        $categoryName = 'Neural Matrix';
        if ($this->selectedSubjectId) {
            $subject = Subject::find($this->selectedSubjectId);
            if ($subject) {
                $categoryName = $subject->name;
            }
        }

        // Save game result
        GameResult::create([
            'user_id' => $user->id,
            'mode' => 'classic',
            'category' => $categoryName,
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
            $user->notify(new \App\Notifications\LevelUpNotification($newLevel));
        }

        // Check for achievements
        \App\Services\AchievementService::check($user);
    }

    public function render()
    {
        return view('livewire.student.arena.classic')
            ->layout('components.layouts.student');
    }
}
