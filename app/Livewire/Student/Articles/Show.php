<?php

namespace App\Livewire\Student\Articles;

use App\Models\Article;
use Livewire\Component;

class Show extends Component
{
    public Article $article;

    public function mount(Article $article)
    {
        if ($article->status !== 'published' && ! auth()->user()->isAdmin()) {
            abort(404);
        }

        $this->article = $article;

        // Increment views
        $this->article->increment('views');
    }

    public function render()
    {
        return view('livewire.student.articles.show')
            ->layout('components.layouts.app');
    }
}
