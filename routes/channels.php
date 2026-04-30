<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Matchmaking kanali: faqat foydalanuvchining o'zi uchun
Broadcast::channel('matchmaking.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Duel kanali: duelda qatnashayotgan ikkita o'yinchi uchun
Broadcast::channel('duel.{uuid}', function ($user, $uuid) {
    $duel = \App\Models\Duel::where('uuid', $uuid)->first();
    
    if (!$duel) return false;
    
    return (int) $user->id === (int) $duel->player1_id || (int) $user->id === (int) $duel->player2_id;
});
