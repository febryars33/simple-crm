<?php

namespace Common\Role;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Role
{
    protected string $selected_role;

    public function __construct(string $name)
    {
        $this->selected_role = $name;
    }

    /**
     * Checks if the currently selected role matches the role of the authenticated user.
     */
    public function check(): bool
    {
        /** @var User $user */
        $user = Auth::user();

        if ($this->selected_role === $user->userable->role->value) {
            return true;
        }

        return false;
    }
}
