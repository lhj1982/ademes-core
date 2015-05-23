# Ademes Core modules
Should include all core modules and functions for different applications


## Installation

Add the following line to the `require` section of `composer.json`:

```json
{
    "require": {
        "ademes/core": "dev-master"
    }
}
```
## Setup

1. Add `'Ademes\Core\CoreServiceProvider',` to the service provider list in `app/config/app.php`.

## Configuration

In order to use the Api Proxy publish its configuration first

```
php artisan config:publish ademes/core
```

Afterwards edit the file ```app/config/packages/ademes/core/core.php``` to suit your needs.


## Usage

### Authentication

```
$authResponse = $app['authClient']->authenticate('admin@admin.com', '000000', 'IhzopIc5SuMf3oUT', 'GUXaqBpeFgN1GKYNTOvh4nOnRpEig4J1');
if ($authResponse) {
    Session::set('AuthToken', $authResponse);
} else {
    throw new Exception('You\'re not authenticated');
}
```

### Fetch User info

1. Get logged in user

```
$user = $app['userClient']->getLoggedInUser($authResponse->getAccessToken());
if ($user) {
    Session::put('data.user', $user);
}
```