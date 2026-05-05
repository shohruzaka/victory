<?php

namespace App\Livewire\Student;

use App\Events\MatchFound;
use App\Models\Duel;
use App\Models\Question;
use App\Models\User;
use App\Notifications\DuelChallengeNotification;
use Illuminate\Support\Str;
use Livewire\Component;

class ChallengeAction extends Component
{
    public function challenge($opponentId)
    {
        $challenger = auth()->user();
        $opponent = User::findOrFail($opponentId);

        // O'zini jangga chorlay olmaydi
        if ($challenger->id === $opponent->id) return;

        // Yangi xususiy duel yaratamiz
        $duel = Duel::create([
            'uuid' => (string) Str::uuid(),
            'player1_id' => $challenger->id,
            'player2_id' => $opponent->id,
            'status' => 'waiting',
            'question_ids' => Question::inRandomOrder()->limit(10)->pluck('id')->toArray(),
        ]);

        // Raqibga xabar yuboramiz
        $opponent->notify(new DuelChallengeNotification($challenger, $duel->uuid));

        $this->dispatch('swal', [
            'title' => 'Chaqiruv yuborildi!',
            'text' => "{$opponent->name} jangga chorlandi. U qabul qilishini kuting.",
            'icon' => 'success'
        ]);
    }

    public function accept($duelUuid)
    {
        $user = auth()->user();
        $duel = Duel::where('uuid', $duelUuid)->where('player2_id', $user->id)->firstOrFail();

        if ($duel->status !== 'waiting') {
            $this->dispatch('swal', ['title' => 'Xatolik', 'text' => 'Bu duel endi faol emas.', 'icon' => 'error']);
            return;
        }

        // Duelni faollashtiramiz
        $duel->update(['status' => 'active']);

        // Challengerga raqib topilgani haqida xabar (Broadcast)
        broadcast(new MatchFound($duel));

        return redirect()->route('arena.duel', $duel->uuid);
    }

    public function decline($duelUuid)
    {
        $user = auth()->user();
        $duel = Duel::where('uuid', $duelUuid)->where('player2_id', $user->id)->firstOrFail();

        $duel->delete(); // Yoki statusni 'declined' qilish mumkin
        
        $this->dispatch('swal', ['title' => 'Rad etildi', 'text' => 'Chaqiruvni bekor qildingiz.', 'icon' => 'info']);
    }

    public function render()
    {
        return <<<'BLADE'
            <div></div>
        BLADE;
    }
}
