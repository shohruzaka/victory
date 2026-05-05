<?php

namespace App\Livewire\Admin\Questions;

use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $subject = '';
    public $topic = '';
    public $difficulty = '';

    protected $queryString = ['search', 'subject', 'topic', 'difficulty'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteQuestion($id)
    {
        Question::findOrFail($id)->delete();
        session()->flash('message', 'Savol muvaffaqiyatli o\'chirildi.');
    }

    public function render()
    {
        $questions = Question::with(['topic.subject', 'options'])
            ->withCount('options')
            ->when($this->search, function($query) {
                $query->where('text', 'like', '%' . $this->search . '%');
            })
            ->when($this->subject, function($query) {
                $query->whereHas('topic.subject', function($q) {
                    $q->where('name', 'like', '%' . $this->subject . '%');
                });
            })
            ->when($this->topic, function($query) {
                $query->whereHas('topic', function($q) {
                    $q->where('name', 'like', '%' . $this->topic . '%');
                });
            })
            ->when($this->difficulty, function($query) {
                $query->where('difficulty', $this->difficulty);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.questions.index', [
            'questions' => $questions
        ])->layout('components.layouts.admin');
    }
}
