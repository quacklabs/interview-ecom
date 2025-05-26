<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\AccountRegistered;
use Illuminate\Support\Str;
use App\Notifications\EmailVerify;
use App\Models\UserVerify;

class AccountRegisterNotify
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AccountRegistered $event): void
    {
        //
        $user = $event->user;
        // User
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
        ]);
        $url = route('verification.verify', ['id' => $user->id, 'hash' => $token]);

        $notification = new EmailVerify($user->username, $url);
        $user->notify($notification);
    }
}
