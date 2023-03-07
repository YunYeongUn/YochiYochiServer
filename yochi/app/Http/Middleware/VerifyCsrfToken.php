<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 여기 클라이언트 주소?
        //'/www.localhost:3000'

        '/JWTregister',
        '/JWTlogin',
        '/api/user'
    ];
}