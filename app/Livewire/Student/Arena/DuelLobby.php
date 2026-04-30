<?php

namespace App\Livewire\Student\Arena;

use App\Events\MatchFound;
use App\Models\Duel;
use App\Models\Question;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\On;

class DuelLobby extends Component
{
    public $isSearching = false;

    public function findMatch()
    {
        $user = auth()->user();
        $this->isSearching = true;

        // 1. Bo'sh turgan (player2 yo'q) duellarni qidirish
        $duel = Duel::where('status', 'waiting')
            ->where('player1_id', '!=', $user->id)
            ->whereNull('player2_id')
            ->first();

        if ($duel) {
            // 2. Raqib topildi! Duelga qo'shilamiz
            $duel->update([
                'player2_id' => $user->id,
                'status' => 'active'
            ]);

            // 3. Ikkala o'yinchiga ham xabar yuboramiz
            broadcast(new MatchFound($duel));

            return redirect()->route('arena.duel', $duel->uuid);
        } else {
            // 4. Bo'sh duel yo'q, yangi navbat yaratamiz
            $newDuel = Duel::create([
                'uuid' => (string) Str::uuid(),
                'player1_id' => $user->id,
                'status' => 'waiting',
                'question_ids' => Question::inRandomOrder()->limit(10)->pluck('id')->toArray(),
            ]);
            
            // Hozircha shu yerda qolib raqib kutamiz
        }
    }

    public function getListeners()
    {
        return [
            "echo-private:matchmaking." . auth()->id() . ",MatchFound" => 'onMatchFound',
        ];
    }

    public function onMatchFound($data)
    {
        return redirect()->route('arena.duel', $data['duel']['uuid']);
    }

    public function render()
    {
        return view('livewire.student.arena.duel-lobby')
            ->layout('components.layouts.student');
    }
}
