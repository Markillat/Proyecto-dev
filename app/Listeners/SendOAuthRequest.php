<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Passport\Passport;

class SendOAuthRequest implements ShouldQueue
{
    use InteractsWithQueue;

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
    public function handle(Authenticated $event): void
    {
        $user = $event->user;

        $scopes = [$user->role];

        $access_token = $user->createToken('Token Name', $scopes)->accessToken;

        Passport::actingAs($user);

        session(['access_token' => $access_token]);
    }
}
