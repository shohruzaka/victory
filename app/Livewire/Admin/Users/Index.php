<?php

namespace App\Livewire\Admin\Users;

use App\Enums\UserRole;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

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

    public function render()
    {
        $users = User::where('role', UserRole::STUDENT)
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('group_name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('livewire.admin.users.index', [
            'users' => $users
        ])->layout('components.layouts.admin');
    }
}
