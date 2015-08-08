# Ademes Core Laravel 5.1 supported

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

### Http Client

Use this class for all request to api services.

Client has 3 methods:
1. GET
2. POST
3. DELETE
Due to limitation of Laravel 4, to be able to make PUT, PATCH request, we have to sende '_method'=>'PUT'/'PATCH' in message body.


#### Request Examples
1. GET
```
$query = $this->http->get($_ENV['API_VERSION'].'/companies', [
    'query' => [
        'access_token' => Session::get('AuthToken')->getAccessToken()
    ]
]);
```
2. POST
```
$data = [
    'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
    'body' => [
        'name' => Input::get('name'),
        'description' => Input::get('description'),
        'url' => Input::get('url'),
        'photo' => fopen($path, 'r'),
        'access_token' => Session::get('AuthToken')->getAccessToken()
    ]
];
$response = $this->http->post($_ENV['API_VERSION'] . '/companies', $data);
```
3. DELETE
```
$body = ['access_token'=>Session::get('AuthToken')->getAccessToken()];
$response = $this->http->delete($_ENV['API_VERSION'] . '/companies/' . $id, ['body'=>$body]);
```
4. PUT
```
$data = [
    'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
    'body' => [
        '_method' => 'PUT',
        'name' => Input::get('name'),
        'description' => Input::get('description'),
        'url' => Input::get('url'),
        'access_token' => Session::get('AuthToken')->getAccessToken()
    ]
];
$response = $this->http->post($_ENV['API_VERSION'] . '/companies/'.$id, $data);
```
