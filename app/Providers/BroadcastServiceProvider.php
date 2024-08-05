<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use App\Events\UserDeleted;

Broadcast::channel('user-deleted.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});