# Laravel Nova Reset Password

Easily reset your Nova password from you dashboard.


## Screenshots

![Laravel Nova Password Reset](https://raw.githubusercontent.com/websnack-dk/nova-password-reset/main/preview-nova-reset-password.png "Laravel Nova Reset Password")

## Requirements

* PHP 8.0
* [Laravel](https://laravel.com/) application with [Laravel Nova](https://nova.laravel.com/) installed

### Installation

Install the package via composer:
```bash
composer require websnack/password-reset
```

Register the tool in the `tools` method of the `NovaServiceProvider`:
```php

// in app/Providers/NovaServiceProvider.php
 
public function tools()
{
    return [
    
        // ...
        
        (new \Websnack\ResetPassword\ResetPassword()),
        
    ];
}
```

## Customizations (Optional)

If you want to specify the min password length, or decide where the url should show, you can publish the config file:
```
php artisan vendor:publish --tag="nova-reset-password-config"
```

Edit `config/nova-password-reset.php` and change desired value:
```
'min_password_length' => 8

'show_on_sidebar' => true,

'show_on_profile_menu' => true,
```
___

## Contributors
[Websnack](https://github.com/websnack-dk)