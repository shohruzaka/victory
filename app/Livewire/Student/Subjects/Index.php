<?php

namespace App\Livewire\Student\Subjects;

use App\Models\Subject;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.student.subjects.index', [
            'subjects' => Subject::withCount('topics')->get(),
        ])
            ->layout('components.layouts.app');
    }
}
