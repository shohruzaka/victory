<?php

namespace App\Livewire\Admin\Questions;

use App\Models\Option;
use App\Models\Question;
use Livewire\Component;

class Form extends Component
{
    public ?Question $question = null;
    
    public $text = '';
    public $subject = '';
    public $topic = '';
    public $difficulty = 'medium';
    public $points = 20;
    
    public $options = [
        ['text' => '', 'is_correct' => true],
        ['text' => '', 'is_correct' => false],
        ['text' => '', 'is_correct' => false],
        ['text' => '', 'is_correct' => false],
    ];

    public function mount(?Question $question = null)
    {
        if ($question && $question->exists) {
            $this->question = $question;
            $this->text = $question->text;
            $this->subject = $question->subject;
            $this->topic = $question->topic;
            $this->difficulty = $question->difficulty;
            $this->points = $question->points;
            
            $this->options = $question->options->map(function($option) {
                return [
                    'id' => $option->id,
                    'text' => $option->text,
                    'is_correct' => (bool) $option->is_correct,
                ];
            })->toArray();
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
            'subject' => 'required',
            'topic' => 'nullable',
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
            'subject' => $this->subject,
            'topic' => $this->topic,
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
