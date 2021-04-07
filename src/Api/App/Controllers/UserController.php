<?php

namespace Dskripchenko\LaravelApiUser\Api\App\Controllers;

use Dskripchenko\LaravelApi\Controllers\ApiController;
use Dskripchenko\LaravelApiUser\Interfaces\UserService;
use Dskripchenko\LaravelApiUser\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 * @package Dskripchenko\LaravelApiUser\Api\App\Controllers
 */
class UserController extends ApiController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     * @param Request $request
     * @param UserService $userService
     */
    public function __construct(Request $request, UserService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    /**
     * Authorized user data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(){
        return $this->success(new UserResource(Auth::user()));
    }

    /**
     * User registration
     *
     * @input string $name Name
     * @input string $email Email
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(){
        $connectionName = config('database.layer');
        $this->request->validate([
            'name' => 'required|string',
            'email' => "required|email|unique:{$connectionName}.users,email"
        ]);

        $user = $this->userService->register();

        return $this->success(new UserResource($user));
    }

    /**
     * Login
     *
     * @input string $email Email
     * @input string $password Password
     * @input integer ?$remember Remember me
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login() {
        $this->request->validate(
            [
                'email'    => 'required|string',
                'password' => 'required|string',
                'remember' => 'boolean',
            ]
        );

        if (!$this->userService->login()) {
            return $this->error($this->userService->getLastError());
        }

        return $this->success(new UserResource(Auth::user()));
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        $this->userService->logout();
        return $this->success();
    }

    /**
     * Password recovery
     *
     * @input string $email Email
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordReset(){
        $this->request->validate([
            'email' => 'required'
        ]);

        if(!$this->userService->resetPassword()) {
            return $this->error($this->userService->getLastError());
        }

        return $this->success();
    }

    /**
     * Set a password for a token from a letter
     *
     * @input string $email Email
     * @input string $token Token
     * @input string $password New Password
     * @input string $password_confirmation Confirmation new password
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function passwordSet() {
        $this->request->validate([
            'email'    => 'required|email',
            'token'    => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if(!$this->userService->passwordSet()) {
            return $this->error($this->userService->getLastError());
        }

        return $this->success(new UserResource(Auth::user()));
    }

    /**
     * Change Password
     *
     * @input string $old_password Current Password
     * @input string $new_password New Password
     * @input string $new_password_confirmation Confirmation new password
     */
    public function passwordChange() {
        $this->request->validate([
            'old_password' => 'password',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $this->userService->passwordChange();

        return $this->success(new UserResource(Auth::user()));
    }
}
