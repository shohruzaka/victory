<?php

namespace App\Livewire\Admin\Questions;

use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Statistics extends Component
{
    use WithPagination;

    public function render()
    {
        // Faqat urinishlar bo'lgan savollarni olamiz va eng qiyinlarini tepaga chiqaramiz
        $questions = Question::where('total_attempts', '>', 0)
            ->select('*')
            ->selectRaw('((total_attempts - correct_attempts) / total_attempts) * 100 as fail_rate')
            ->orderByDesc('fail_rate')
            ->orderByDesc('total_attempts')
            ->paginate(15);

        return view('livewire.admin.questions.statistics', [
            'questions' => $questions
        ])->layout('components.layouts.admin');
    }
}
