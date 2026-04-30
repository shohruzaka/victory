<?php

namespace App\Livewire\Admin\Subjects;

use App\Models\Subject;
use App\Models\Topic;
use Livewire\Component;

class Index extends Component
{
    public $newSubjectName = '';
    public $editingSubjectId = null;
    public $editSubjectName = '';

    public $selectedSubjectId = null;
    public $newTopicName = '';
    public $editingTopicId = null;
    public $editTopicName = '';

    protected $rules = [
        'newSubjectName' => 'required|min:2|unique:subjects,name',
        'newTopicName' => 'required|min:2',
    ];

    public function addSubject()
    {
        $this->validate(['newSubjectName' => 'required|min:2|unique:subjects,name']);
        Subject::create(['name' => $this->newSubjectName]);
        $this->newSubjectName = '';
        session()->flash('message', 'Fan qo\'shildi.');
    }

    public function deleteSubject($id)
    {
        Subject::findOrFail($id)->delete();
        if ($this->selectedSubjectId == $id) $this->selectedSubjectId = null;
    }

    public function selectSubject($id)
    {
        $this->selectedSubjectId = $id;
        $this->newTopicName = '';
    }

    public function addTopic()
    {
        if (!$this->selectedSubjectId) return;
        $this->validate(['newTopicName' => 'required|min:2']);
        
        Topic::create([
            'subject_id' => $this->selectedSubjectId,
            'name' => $this->newTopicName
        ]);
        
        $this->newTopicName = '';
        session()->flash('topic_message', 'Mavzu qo\'shildi.');
    }

    public function deleteTopic($id)
    {
        Topic::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.subjects.index', [
            'subjects' => Subject::withCount('topics')->get(),
            'selectedSubject' => $this->selectedSubjectId ? Subject::with('topics')->find($this->selectedSubjectId) : null,
        ])->layout('components.layouts.admin');
    }
}
