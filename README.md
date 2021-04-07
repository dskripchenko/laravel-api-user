## Installation

Run
```
composer config --global --auth http-basic.pkg.extteam.ru {USERNAME} {TOKEN}
``` 
to register a private packages registry, and run
```
php composer.phar require components/user "@dev"
```

or add

```
"components/user": "@dev"
```

to the ```require``` section of your `composer.json` file.

## Api
* /user/info
* /user/register
* /user/login
* /user/logout
* /user/password-reset
* /user/password-set
* /user/password-change

## Middlewares
* VerifyAuth
* UseMainLayerConnection

## Models
* User

## Interfaces
* User
* UserService

## Services
* UserService

## Notifications
* ResetPassword
* UserCreated

## Validators
* can:permission

## functions
* can
