<?php

namespace App\Livewire\Student\Arena;

use App\Models\Question;
use Livewire\Component;

class Setup extends Component
{
    public $mode; // classic, speedrun, survival
    public $selectedSubject = '';
    public $selectedTopic = '';

    public $subjects = [];
    public $topics = [];

    public function mount($mode)
    {
        $this->mode = $mode;
        $this->subjects = Question::distinct()->pluck('subject')->filter()->toArray();
    }

    public function updatedSelectedSubject($value)
    {
        $this->selectedTopic = '';
        if ($value) {
            $this->topics = Question::where('subject', $value)
                ->distinct()
                ->pluck('topic')
                ->filter()
                ->toArray();
        } else {
            $this->topics = [];
        }
    }

    public function startMission()
    {
        $params = [
            'subject' => $this->selectedSubject,
            'topic' => $this->selectedTopic,
        ];

        return redirect()->route('arena.' . $this->mode, array_filter($params));
    }

    public function render()
    {
        return view('livewire.student.arena.setup')
            ->layout('components.layouts.student');
    }
}
