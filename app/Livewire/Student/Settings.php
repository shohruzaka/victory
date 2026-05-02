<?php

namespace App\Livewire\Student;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;

    public $name;

    public $group_name;

    public $avatar;

    public $currentAvatar;

    // Password fields
    public $current_password;

    public $password;

    public $password_confirmation;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->group_name = $user->group_name;
        $this->currentAvatar = $user->avatar_url;
    }

    public function save()
    {
        $user = User::find(auth()->id());

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

    public function updatePassword(UpdatesUserPasswords $updater)
    {
        $this->resetErrorBag();

        try {
            $updater->update(auth()->user(), [
                'current_password' => $this->current_password,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ]);

            $this->reset(['current_password', 'password', 'password_confirmation']);

            session()->flash('password_message', 'Parol muvaffaqiyatli yangilandi.');
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->errors());
        }
    }

    public function render()
    {
        return view('livewire.student.settings')
            ->layout('components.layouts.student');
    }
}
