<?php

namespace Dskripchenko\LaravelApiUser\Validators;

use Dskripchenko\LaravelApiUser\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

/**
 * Class CanValidator
 * @package Dskripchenko\LaravelApiUser\Validators
 */
class CanValidator extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('can', function (string $attribute, $value, $parameters, \Illuminate\Validation\Validator $validator){
            /** @var User $user */
            $user = auth()->user();

            foreach ($parameters as $parameter) {
                if ($user->allowAbility($parameter, ['attribute' => $attribute, 'value' => $value])) {
                    return true;
                }
            }
            return false;
        }, 'Permission denied');
    }
}
