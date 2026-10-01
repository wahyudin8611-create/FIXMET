<?php

namespace App\Policies;

use App\Models\Consultation;
use App\Models\User;

class ConsultationPolicy
{
    /**
     * Guest consultations are reached through their unguessable access token,
     * so holding the link is enough. Saved consultations stay private.
     */
    public function view(?User $user, Consultation $consultation): bool
    {
        if ($consultation->isGuest()) {
            return true;
        }

        return $user !== null && ($user->id === $consultation->user_id || $user->isAdmin());
    }

    public function update(?User $user, Consultation $consultation): bool
    {
        if ($consultation->isGuest()) {
            return true;
        }

        return $user !== null && $user->id === $consultation->user_id;
    }
}
