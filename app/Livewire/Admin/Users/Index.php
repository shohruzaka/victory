<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // Password change fields
    public $changingPasswordUserId = null;

    public $newPassword = '';

    public $newPasswordConfirmation = '';

    public $isPasswordModalOpen = false;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            session()->flash('error', 'O\'zingizni o\'chira olmaysiz.');

            return;
        }

        $user->delete();
        session()->flash('message', 'Foydalanuvchi muvaffaqiyatli o\'chirildi.');
    }

    public function openPasswordModal($userId)
    {
        $this->changingPasswordUserId = $userId;
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';
        $this->isPasswordModalOpen = true;
    }

    public function closePasswordModal()
    {
        $this->isPasswordModalOpen = false;
        $this->changingPasswordUserId = null;
    }

    public function generateRandomPassword()
    {
        $this->newPassword = Str::random(10);
        $this->newPasswordConfirmation = $this->newPassword;
    }

    public function updateUserPassword()
    {
        $this->validate([
            'newPassword' => 'required|min:8',
            'newPasswordConfirmation' => 'same:newPassword',
        ]);

        $user = User::findOrFail($this->changingPasswordUserId);
        $user->password = Hash::make($this->newPassword);
        $user->save();

        $this->closePasswordModal();
        session()->flash('message', 'Foydalanuvchi paroli muvaffaqiyatli yangilandi.');
    }

    public function toggleRole(User $user)
    {
        // Faqatgina Super Admin (ID=1) boshqa foydalanuvchilar rolini o'zgartira oladi.
        if (auth()->id() !== 1) {
            session()->flash('error', 'Sizda foydalanuvchilar rolini o\'zgartirish huquqi (Super Admin ruxsati) yo\'q.');
            return;
        }

        if ($user->id === auth()->id()) {
            session()->flash('error', 'O\'z rolingizni o\'zingiz o\'zgartira olmaysiz.');
            return;
        }

        $newRole = $user->role === UserRole::ADMIN->value ? UserRole::STUDENT->value : UserRole::ADMIN->value;
        $user->update(['role' => $newRole]);

        session()->flash('message', "{$user->name} roli muvaffaqiyatli o'zgartirildi.");
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('group_name', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('role', 'asc') // Adminlarni tepada ko'rsatish uchun
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('livewire.admin.users.index', [
            'users' => $users,
        ])->layout('components.layouts.admin');
    }
}
