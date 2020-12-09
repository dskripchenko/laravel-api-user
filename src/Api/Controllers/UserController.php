<?php

namespace Dskripchenko\LaravelApiUser\Api\Controllers;

use Dskripchenko\LaravelApi\Components\ApiController;
use Dskripchenko\LaravelApiUser\Interfaces\UserService;
use Dskripchenko\LaravelApiUser\Api\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Данные по авторизованному пользователю
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(){
        return $this->success(new UserResource(Auth::user()));
    }

    /**
     * Регистрация пользователя
     *
     * @input string $login Логин
     * @input string $options Дополнительные свойства пользователя
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(){
        $this->request->validate([
            'login' => 'required|email|unique:users,login',
            'options' => 'json'
        ]);

        $user = $this->userService->register();

        return $this->success(new UserResource($user));
    }

    /**
     * Логин
     *
     * @input string $login Логин
     * @input string $password Пароль
     * @input int ?$remember Помнить меня
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Dskripchenko\LaravelApi\Components\ApiException
     */
    public function login(){
        $this->request->validate([
            'login'    => 'required|email',
            'password' => 'required|string',
        ]);

        if(!$this->userService->login()){
            return $this->error($this->userService->getLastError());
        }

        return $this->success(new UserResource(Auth::user()));
    }

    /**
     * Логаут
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        $this->userService->logout();
        return $this->success();
    }

    /**
     * Восстановления пароля
     *
     * @input string $login Логин
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Dskripchenko\LaravelApi\Components\ApiException
     */
    public function passwordReset(){
        $this->request->validate([
            'login' => 'required'
        ]);

        if(!$this->userService->resetPassword()) {
            return $this->error($this->userService->getLastError());
        }

        return $this->success();
    }

    /**
     * Установить пароль по токену из письма
     *
     * @input string $login Емайл
     * @input string $token Токен
     * @input string $password Новый пароль
     * @input string $password_confirmation Повторение пароля
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Dskripchenko\LaravelApi\Components\ApiException
     */
    public function passwordSet() {
        $this->request->validate([
            'login'    => 'required|email',
            'token'    => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if(!$this->userService->passwordSet()) {
            return $this->error($this->userService->getLastError());
        }

        return $this->success(new UserResource(Auth::user()));
    }

    /**
     * Изменить пароль
     *
     * @input string $old_passwordтекущий пароль
     * @input string $new_password новый пароль
     * @input string $new_password_confirmation новый пароль еще раз
     */
    public function passwordChange() {
        $this->request->validate([
            'old_password' => 'password',
            'new_password'     => 'required|confirmed|min:8',
        ]);

        $this->userService->passwordChange();

        return $this->success(new UserResource(Auth::user()));
    }
}
