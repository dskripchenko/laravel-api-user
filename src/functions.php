<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable;

if (!function_exists('can')) {
    /**
     * @param string $ability
     * @param Authenticatable|null $user
     * @return bool
     */
    function can(string $ability, Authenticatable $user = null): bool
    {
        if (!$user) {
            $user = Auth::user();
        }

        if (!$user) {
            return false;
        }

        if (! $user instanceof Authorizable) {
            return false;
        }

        return $user->can($ability);
    }
}
