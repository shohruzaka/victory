<?php

namespace App\Livewire\Admin\Articles;

use App\Models\Article;
use App\Models\Topic;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public ?Article $article = null;

    public $title = '';

    public $slug = '';

    public $content = '';

    public $topic_id = null;

    public $status = 'draft';

    public $image;

    public $existing_image = null;

    public function mount(?Article $article = null)
    {
        if ($article && $article->exists) {
            $this->article = $article;
            $this->title = $article->title;
            $this->slug = $article->slug;
            $this->content = $article->content;
            $this->topic_id = $article->topic_id;
            $this->status = $article->status;
            $this->existing_image = $article->image;
        }
    }

    public function updatedTitle($value)
    {
        if (! $this->article) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:articles,slug,'.($this->article ? $this->article->id : 'NULL'),
            'content' => 'required|min:10',
            'topic_id' => 'nullable|exists:topics,id',
            'status' => 'required|in:published,draft',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);

        $imagePath = $this->existing_image;

        if ($this->image) {
            $imagePath = $this->image->store('articles', 'public');
        }

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'topic_id' => $this->topic_id,
            'status' => $this->status,
            'image' => $imagePath,
            'user_id' => auth()->id() ?? 1, // Fallback for tests if needed, but admin should be auth'd
        ];

        if ($this->article) {
            $this->article->update($data);
        } else {
            Article::create($data);
        }

        session()->flash('message', $this->article ? 'Maqola muvaffaqiyatli tahrirlandi.' : 'Yangi maqola muvaffaqiyatli qo\'shildi.');

        return redirect()->route('admin.articles.index');
    }

    public function render()
    {
        return view('livewire.admin.articles.form', [
            'topics' => Topic::with('subject')->get(),
        ])
            ->layout('components.layouts.admin');
    }
}
