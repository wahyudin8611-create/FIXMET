<?php

namespace App\Listeners;

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Auth\Events\Login;

class ClaimGuestConsultations
{
    /**
     * Attach the diagnoses made before signing in to the account that just
     * signed in, so nothing done as a guest is lost.
     */
    public function handle(Login $event): void
    {
        $consultationIds = session()->pull(Consultation::GUEST_SESSION_KEY, []);

        if ($consultationIds === [] || ! $event->user instanceof User || ! $event->user->isUser()) {
            return;
        }

        Consultation::query()
            ->whereIn('id', $consultationIds)
            ->whereNull('user_id')
            ->update(['user_id' => $event->user->id]);
    }
}
