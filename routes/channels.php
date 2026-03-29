<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('admin-notifications', function (User $user) {
    // فقط اللي نوع حسابهم admin مسموح لهم يسمعون للإشعارات
    return $user->role === 'admin';
});
