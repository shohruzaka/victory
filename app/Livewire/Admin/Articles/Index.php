<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $status = '';

    protected $queryString = ['search', 'status'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteArticle($id)
    {
        Article::findOrFail($id)->delete();
        session()->flash('message', 'Maqola muvaffaqiyatli o\'chirildi.');
    }

    public function render()
    {
        $articles = Article::with('user')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.articles.index', [
            'articles' => $articles,
        ])->layout('components.layouts.admin');
    }
}
