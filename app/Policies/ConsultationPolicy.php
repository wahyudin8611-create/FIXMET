<?php

namespace App\Policies;

use App\Models\Consultation;
use App\Models\User;

class ConsultationPolicy
{
    public function view(User $user, Consultation $consultation): bool
    {
        return $user->id === $consultation->user_id || $user->isAdmin();
    }

    public function update(User $user, Consultation $consultation): bool
    {
        return $user->id === $consultation->user_id;
    }
}
