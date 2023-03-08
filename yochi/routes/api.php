<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/JWTregister', [JWTAuthController::class,'register'])->name('api.jwt.register'); // JWT 회원가입

Route::post('/JWTlogin', [JWTAuthController::class,'login'])->name('api.jwt.login'); // JWT 로그인 (최초토큰발행)

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('unauthorized', function() { // 인증실패에러
    return response()->json([
        'status' => 'error',
        'message' => 'Unauthorized'
    ], 401);
})->name('api.jwt.unauthorized');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user', [JWTAuthController::class,'user'])->name('api.jwt.user'); // 유저 정보 가져오기
    Route::get('refresh', [JWTAuthController::class,'refresh'])->name('api.jwt.refresh'); // 토큰재발행
    Route::get('logout', [JWTAuthController::class,'logout'])->name('api.jwt.logout'); // 로그아웃
});