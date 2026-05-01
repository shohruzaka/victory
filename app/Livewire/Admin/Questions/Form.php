<?php

namespace App\Livewire\Admin\Questions;

use App\Models\Option;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use Livewire\Component;

class Form extends Component
{
    public ?Question $question = null;
    
    public $text = '';
    public $subject_id = '';
    public $topic_id = '';
    public $difficulty = 'medium';
    public $points = 20;
    
    public $subjects = [];
    public $topics = [];

    public $options = [
        ['text' => '', 'is_correct' => true],
        ['text' => '', 'is_correct' => false],
        ['text' => '', 'is_correct' => false],
        ['text' => '', 'is_correct' => false],
    ];

    public function mount(?Question $question = null)
    {
        $this->subjects = Subject::all();

        if ($question && $question->exists) {
            $this->question = $question;
            $this->text = $question->text;
            $this->subject_id = $question->topic->subject_id ?? '';
            $this->topic_id = $question->topic_id;
            $this->difficulty = $question->difficulty;
            $this->points = $question->points;
            
            if ($this->subject_id) {
                $this->topics = Topic::where('subject_id', $this->subject_id)->get();
            }

            $this->options = $question->options->map(function($option) {
                return [
                    'id' => $option->id,
                    'text' => $option->text,
                    'is_correct' => (bool) $option->is_correct,
                ];
            })->toArray();
        }
    }

    public function updatedSubjectId($value)
    {
        $this->topic_id = '';
        if ($value) {
            $this->topics = Topic::where('subject_id', $value)->get();
        } else {
            $this->topics = [];
        }
    }

    public function updatedDifficulty($value)
    {
        $this->points = Question::getPointsByDifficulty($value);
    }

    public function addOption()
    {
        $this->options[] = ['text' => '', 'is_correct' => false];
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function setCorrect($index)
    {
        foreach ($this->options as $i => $option) {
            $this->options[$i]['is_correct'] = ($i === $index);
        }
    }

    public function save()
    {
        $this->validate([
            'text' => 'required|min:5',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'required|exists:topics,id',
            'difficulty' => 'required|in:easy,medium,hard',
            'points' => 'required|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*.text' => 'required',
        ]);

        // Ensure at least one correct answer
        $hasCorrect = collect($this->options)->contains('is_correct', true);
        if (!$hasCorrect) {
            $this->addError('options', 'Kamida bitta to\'g\'ri javobni belgilashingiz kerak.');
            return;
        }

        $data = [
            'text' => $this->text,
            'topic_id' => $this->topic_id,
            'difficulty' => $this->difficulty,
            'points' => $this->points,
        ];

        if ($this->question) {
            $this->question->update($data);
            $this->question->options()->delete();
            $question = $this->question;
        } else {
            $question = Question::create($data);
        }

        foreach ($this->options as $optionData) {
            $question->options()->create([
                'text' => $optionData['text'],
                'is_correct' => $optionData['is_correct'],
            ]);
        }

        session()->flash('message', $this->question ? 'Savol muvaffaqiyatli tahrirlandi.' : 'Yangi savol muvaffaqiyatli qo\'shildi.');
        return redirect()->route('admin.questions.index');
    }

    public function render()
    {
        return view('livewire.admin.questions.form')
            ->layout('components.layouts.admin');
    }
}
