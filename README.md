# HSC Auth

Authentication solution.

This package is based on `amoschou/laravel-remote-auth`. It provides a Filr driver for `laravel-remote-auth` and integrates Socialite via Google. Socialite integration is an optional part of the package.

## Installation

Install the package using Composer:
```
composer require amoschou218/hsc-auth
```

## Config

Include a provider with the Filr driver in the `config/remote_auth.php`:

```php
'hsc-filr' => \HamiltonSC\Auth\App\Drivers\Filr::class
```

The settings go like:
```php
'hsc-filr' => [
    'connection' => 'https://filr.example.com:8443/rest'
    'profile_map' => [
        'username' => 'name',
        'first_name' => 'first_name',
        'last_name' => 'last_name',
        'display_name' => 'title',
        'id' => 'phone',
        'email' => 'email',
    ],
],
```

There is no need for a `groups` key in the `profile_map`, as groups are applied anyway.

## Socialite

If the setting `remote_auth.socialite.google` is `true`, then you will need to configure Socialite. See https://laravel.com/docs/10.x/socialite.

If this setting is not present, by default it will be considered `false`.

