<?php

namespace App\Policies;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailTemplatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, EmailTemplate $emailTemplate)
    {
        return $user->id === $emailTemplate->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\EmailTemplate  $emailTemplate
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, EmailTemplate $emailTemplate)
    {
        return $user->id === $emailTemplate->user_id;
    }
}
