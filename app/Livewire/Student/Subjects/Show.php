<?php

namespace App\Livewire\Student\Subjects;

use App\Models\Subject;
use Livewire\Component;

class Show extends Component
{
    public Subject $subject;

    public function mount(Subject $subject)
    {
        $this->subject = $subject->load(['topics.articles' => function ($query) {
            $query->where('status', 'published');
        }]);
    }

    public function render()
    {
        return view('livewire.student.subjects.show')
            ->layout('components.layouts.app');
    }
}
