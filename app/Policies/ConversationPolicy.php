<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Conversation $conversation): bool
    {
        return $user->id === $conversation->user_id || $user->id === $conversation->agent_id;
    }

    /**
     * Determine whether the user can update the model (e.g. send a message).
     */
    public function update(User $user, Conversation $conversation): bool
    {
        return $this->view($user, $conversation);
    }
}
