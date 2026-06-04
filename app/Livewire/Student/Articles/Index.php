<?php

namespace App\Livewire\Student\Articles;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.student.articles.index', [
            'articles' => Article::where('status', 'published')
                ->with(['topic.subject', 'user'])
                ->latest()
                ->paginate(12),
        ])
            ->layout('components.layouts.app');
    }
}
