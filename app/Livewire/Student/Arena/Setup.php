<?php

namespace App\Livewire\Student\Arena;

use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
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
        $this->subjects = Subject::all();
    }

    public function updatedSelectedSubject($value)
    {
        $this->selectedTopic = '';
        if ($value) {
            $this->topics = Topic::where('subject_id', $value)->get();
        } else {
            $this->topics = [];
        }
    }

    public function startMission()
    {
        $params = [
            'subject_id' => $this->selectedSubject,
            'topic_id' => $this->selectedTopic,
        ];

        return redirect()->route('arena.' . $this->mode, array_filter($params));
    }

    public function render()
    {
        return view('livewire.student.arena.setup')
            ->layout('components.layouts.student');
    }
}
