<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class Settings extends Component
{
    use WithFileUploads;

    public $name;
    public $group_name;
    public $avatar;
    public $currentAvatar;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->group_name = $user->group_name;
        $this->currentAvatar = $user->avatar_url;
    }

    public function save()
    {
        $user = \App\Models\User::find(auth()->id());

        $this->validate([
            'name' => 'required|string|max:255',
            'group_name' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $user->name = $this->name;
        $user->group_name = $this->group_name;

        if ($this->avatar) {
            // Delete old avatar if exists and is not a default/external URL
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        // Refresh state
        $this->currentAvatar = $user->avatar_url;
        $this->avatar = null;

        session()->flash('message', 'Profil sozlamalari muvaffaqiyatli yangilandi.');
    }

    public function render()
    {
        return view('livewire.student.settings')
            ->layout('components.layouts.student');
    }
}
