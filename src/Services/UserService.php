<?php

namespace Dskripchenko\LaravelApiUser\Services;

use \Dskripchenko\LaravelApiUser\Interfaces\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use \Dskripchenko\LaravelApiUser\Interfaces\UserService as UserServiceInterface;

/**
 * Class UserService
 * @package Dskripchenko\LaravelApiUser\Services
 */
class UserService implements UserServiceInterface
{
    use ThrottlesLogins;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var mixed
     */
    protected $lastError;

    public function __construct(User $user, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }


    public function username(){
        return 'email';
    }

    /**
     * @return User
     */
    public function register() : User {
        $email = $this->request->email;
        $name = $this->request->name;
        return $this->user->register($email, $name);
    }

    /**
     * @return bool
     */
    public function logout() : bool {
        Auth::guard()->logout();
        $this->request->session()->invalidate();
        return true;
    }

    /**
     * @return bool
     */
    public function login() : bool {
        if ($this->hasTooManyLoginAttempts($this->request)) {
            $this->fireLockoutEvent($this->request);
            $seconds = $this->limiter()->availableIn($this->throttleKey($this->request));
            $error = trans('auth.throttle', ['seconds' => $seconds, 'minutes' => ceil($seconds / 60)]);
            $this->lastError = ['login' => [$error]];
            return false;
        }

        $remember = $this->request->input('remember', 0) == 1;
        if(!Auth::guard()->attempt($this->request->only('email', 'password'), $remember)) {
            $this->incrementLoginAttempts($this->request);
            $this->lastError = ['login' => [trans('auth.failed')]];
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function resetPassword() : bool {
        $result = Password::sendResetLink($this->request->only('email'));
        if($result !== Password::RESET_LINK_SENT) {
            $this->lastError = ['email' => trans($result)];
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function passwordSet() : bool {
        $credentials = $this->request->only('email', 'password', 'password_confirmation', 'token');

        $callback = function ($user, $password) {
            $user->password = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();

            event(new PasswordReset($user));
            Auth::guard()->login($user);
        };

        $result = Password::reset($credentials, $callback);

        if($result !== Password::PASSWORD_RESET) {
            $this->lastError = ['email' => trans($result)];
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function passwordChange() : bool {
        /**
         * @var User $user
         */
        $user = Auth::user();
        $user->password = Hash::make($this->request->new_password);
        $user->setRememberToken(Str::random(60));
        $user->save();
        Auth::guard()->login($user);
        return true;
    }

    /**
     * @return mixed
     */
    public function getLastError() {
        return $this->lastError;
    }
}
