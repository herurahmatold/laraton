# Laraton
Skeleton/ Complete App Starter with Laravel

Developed by [herurahmat](https://github.com/herurahmat)


## Environment

- [x] PHP 7.2.10
- [x] MySQL 8.0.16-Mysql Community
- [x] Laravel 6.2

## How to Implement

- Git Clone https://github.com/herurahmat/laraton.git
- Run `composer install`
- Copy `.env` file from `.env.example` using command `cp .env.example .env` then make some configs in `.env` file (please check `Config .env` Section)
- Make sure `DB_DATABASE` is set correctly in `.env` file then run `php artisan migrate`
- Run php artisan db:seed
- If migration is failed, please run `composer dump-autoload` first and remove any table(s) in database before execute migrate again
- Default admin user is `admin` with password `admin`
- Make Controller, php artisan make:controller . Code to call view :
```php
$data=my_dummy_data();
return laraview('my.view',['title'=>'My Title'],$data);
```
- In view blade. You not create script for template again. It's Automatically !!
- Please show app\Helpers for another cheating script !!

## Documentation
[https://github.com/herurahmat/laraton-doc](https://github.com/herurahmat/laraton-doc "Documentation")

## Modules

- [x] Login
- [x] Template
- [x] Helper
- [x] Avatar
- [x] Thumbnail Image Upload
- [x] Profile
- [x] User Manager
- [x] Usergroup Manager
- [x] Application Configuration
- [x] Company Configuration
- [x] Logo & Favicon

