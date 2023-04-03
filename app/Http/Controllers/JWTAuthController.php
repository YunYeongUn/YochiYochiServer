<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RefreshToken;
//use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWT;

class JWTAuthController extends Controller
{
    public function user() { // 사용자정보 가져오기
        return response()->json(Auth::guard('api')->user());
    }

    public function register(Request $request) { // 회원가입
        
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255|confirmed',
            'password_confirmation' => 'required|string|min:8|max:255',
            'tel'  => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()
            ], 200);
        }
        

        $user = new User;
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()
            ], 200);
        }
        // 리프레시 토큰 생성
        if (!$token = Auth::guard('api')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' => 'Un'], 401);
        }

        // 토큰 검사
        try {
            JWTAuth::setToken($token)->check();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        }

        // 로그인된 사용자 정보 가져오기
        $user = Auth::guard('api')->user();

        // 액세스 토큰 생성
        $accessToken = Auth::guard('api')->setTTL(config('jwt.JWT_TTL'))->refresh();

        //리프레시 토큰 DB 저장
        $saveT = new RefreshToken;
        $saveT->user_id = $user->id;
        $saveT->refresh_token = $token;
        $saveT->save();

        // 액세스 토큰과 함께 응답
        
        $response = response()->json([
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]); 
        return $response;
    }

    public function refresh(Request $request)
    {
        try {
            // 요청에서 전달된 refresh_token 값을 조회합니다.
            $refreshToken = $request->post('refresh_token');

            // RefreshToken 모델에서 해당 refresh_token 값을 갖는 토큰을 조회합니다.
            $token = RefreshToken::where('refresh_token', $refreshToken)->orderBy('created_at', 'desc')->first();
          
            // 조회된 토큰이 없을 경우, 유효하지 않은 토큰으로 처리합니다.
            if (!$token) {
                return response()->json(['error' => 'Invalid refresh token'], 401);
            }

            // 조회된 토큰을 사용하여 사용자 모델에서 액세스 토큰을 발급합니다.
            $user = User::find($token->user_id);
            $newToken = JWTAuth::fromUser($user);

            // 발급된 액세스 토큰을 HTTP 응답에 담아 반환합니다.
            return $this->respondWithToken($newToken);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token invalid'], 401);
        }
    }
    

    private function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }
    

    public function logout() { // 로그아웃
        $user = Auth::guard('api')->user()->id; 
        Auth::guard('api')->logout();
        $token = RefreshToken::where('user_id', $user);
        $token-> delete();
        return response()->json([
            'status' => 'success',
            'message' => 'logout'
        ], 200);
    }

    public function authenticate(Request $request)
    {
        // 현재 로그인된 사용자 정보를 가져옵니다.
        $user = Auth::user();
        $headers = $request->header();
        
        if ($user) {
            // 토큰 인증에 성공한 경우, 인증된 사용자 정보를 반환합니다.
            return response()->json([
                'ok' => true,
                'user' => $user
            ]);
        } else {
            // 토큰 인증에 실패한 경우, 인증 실패에 대한 정보를 반환합니다.
            //Log::error('Failed to authenticate user.');
            return response()->json([
                'ok' => false,
                'msg' => 'Unauthorized',
                'header' => $headers
            ], 401);
        }

    }

}