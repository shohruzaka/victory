<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function getListeners()
    {
        $userId = Auth::id();
        return [
            "echo-private:App.Models.User.{$userId},Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'onNotificationReceived',
        ];
    }

    public function onNotificationReceived($data)
    {
        $this->loadNotifications();
        $this->dispatch('notification-sound'); // Play sound effect on UI
    }

    public function loadNotifications()
    {
        $user = Auth::user();
        if ($user) {
            $this->notifications = $user->notifications()->latest()->limit(5)->get();
            $this->unreadCount = $user->unreadNotifications()->count();
        }
    }

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->loadNotifications();
    }

    public function clearAll()
    {
        Auth::user()->notifications()->delete();
        $this->loadNotifications();
        $this->dispatch('swal', [
            'title' => 'Logs Purged',
            'text' => 'All neural notifications have been cleared from your system.',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.student.notification-bell');
    }
}
