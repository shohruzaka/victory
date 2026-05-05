<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Settings extends Component
{
    public $classicQuestionsLimit;
    public $speedrunQuestionsLimit;
    public $speedrunTimeLimit;

    public function mount()
    {
        $this->classicQuestionsLimit = Cache::get('setting_classic_limit', 10);
        $this->speedrunQuestionsLimit = Cache::get('setting_speedrun_limit', 10);
        $this->speedrunTimeLimit = Cache::get('setting_speedrun_time', 15);
    }

    public function save()
    {
        $this->validate([
            'classicQuestionsLimit' => 'required|numeric|min:1|max:50',
            'speedrunQuestionsLimit' => 'required|numeric|min:1|max:50',
            'speedrunTimeLimit' => 'required|numeric|min:5|max:120',
        ]);

        Cache::forever('setting_classic_limit', (int) $this->classicQuestionsLimit);
        Cache::forever('setting_speedrun_limit', (int) $this->speedrunQuestionsLimit);
        Cache::forever('setting_speedrun_time', (int) $this->speedrunTimeLimit);

        $this->dispatch('swal', [
            'title' => 'Settings Updated',
            'text' => 'Game mode parameters have been synchronized across the matrix.',
            'icon' => 'success'
        ]);
    }

    public function render()
    {
        return view('livewire.admin.settings')
            ->layout('components.layouts.admin');
    }
}
