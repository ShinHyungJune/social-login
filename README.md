# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/shinhyungjune/social-login.svg?style=flat-square)](https://packagist.org/packages/shinhyungjune/social-login)
[![Total Downloads](https://img.shields.io/packagist/dt/shinhyungjune/social-login.svg?style=flat-square)](https://packagist.org/packages/shinhyungjune/social-login)
![GitHub Actions](https://github.com/shinhyungjune/social-login/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Requirements
- Inertia.js 설정 필요(https://ssa4141.tistory.com/139?category=964558 참고)
- 메일 설정 및 비밀번호 초기화 세팅 필요(https://ssa4141.tistory.com/95 참고)
- 네이버, 카카오 등 각 사이트에서 페이지 등록 필요
- 기존 create_users가 아닌 패키지에서 제공하는 create_users migration 필요

## Installation

You can install the package via composer:

```bash
composer require shinhyungjune/social-login
php artisan vendor:publish
```

## Usage

```php
// Usage description here
```
@web.php
```php
Route::get("/", function(){
    return \Inertia\Inertia::render("Home");
});
Route::get("/home", function(){
    return \Inertia\Inertia::render("Home");
});

Route::middleware("guest")->group(function(){
    Route::get("/openLoginPop/{social}", [\ShinHyungJune\SocialLogin\Http\UserController::class, "openSocialLoginPop"]);
    Route::get("/login", [\ShinHyungJune\SocialLogin\Http\UserController::class, "index"])->name("login");
    Route::get("/login/{social}", [\ShinHyungJune\SocialLogin\Http\UserController::class, "socialLogin"]);
    Route::post("/login", [\ShinHyungJune\SocialLogin\Http\UserController::class, "login"]);
    Route::resource("/users", \ShinHyungJune\SocialLogin\Http\UserController::class);
    Route::get("/passwordResets/{token}/edit", [\ShinHyungJune\SocialLogin\Http\PasswordResetController::class, "edit"]);
    Route::resource("/passwordResets", \ShinHyungJune\SocialLogin\Http\PasswordResetController::class);
});

Route::middleware("auth")->group(function(){
    Route::get("/logout", [\ShinHyungJune\SocialLogin\Http\UserController::class, "logout"]);
});

Route::get("/mailable", function(){
    return (new \App\Mail\PasswordResetCreated(new \App\Models\User(), new \App\Models\PasswordReset()));
});

```

@.env(카카오는 secret key가 따로 없어서 입력 안해도됨)
```php
KAKAO_CLIENT_ID=
KAKAO_CLIENT_SECRET=
KAKAO_REDIRECT_URI={your_url}/login/kakao

NAVER_CLIENT_ID=
NAVER_CLIENT_SECRET=
NAVER_REDIRECT_URI={your_url}/login/naver

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI={your_url}/login/google

FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT_URI={your_url}/login/facebook
```

@EventServiceProvider
```php 
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ... other providers
        'SocialiteProviders\\Naver\\NaverExtendSocialite@handle',
        'SocialiteProviders\\Kakao\\KakaoExtendSocialite@handle',
        'SocialiteProviders\\Facebook\\FacebookExtendSocialite@handle',
        'SocialiteProviders\\Google\\GoogleExtendSocialite@handle',
    ],
];
```

@services.php
```php 
'naver' => [
  'client_id' => env('NAVER_CLIENT_ID'),  
  'client_secret' => env('NAVER_CLIENT_SECRET'),  
  'redirect' => env('NAVER_REDIRECT_URI') 
],

'kakao' => [    
  'client_id' => env('KAKAO_CLIENT_ID'),  
  'client_secret' => env('KAKAO_CLIENT_SECRET'),  
  'redirect' => env('KAKAO_REDIRECT_URI') 
],

'google' => [    
  'client_id' => env('GOOGLE_CLIENT_ID'),  
  'client_secret' => env('GOOGLE_CLIENT_SECRET'),  
  'redirect' => env('GOOGLE_REDIRECT_URI') 
],

'facebook' => [    
  'client_id' => env('FACEBOOK_CLIENT_ID'),  
  'client_secret' => env('FACEBOOK_CLIENT_SECRET'),  
  'redirect' => env('FACEBOOK_REDIRECT_URI') 
],
```

@User.php
```php 
protected $fillable = [
        ...
        "social_id",
        "social_platform"
    ];
```
### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ssa4141@naver.com instead of using the issue tracker.

## Credits

-   [HyungJune Shin](https://github.com/shinhyungjune)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
