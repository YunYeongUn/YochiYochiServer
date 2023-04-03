<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\QnaController;
use App\Http\Controllers\QnaAnswerController;
use App\Http\Controllers\ScoreboardController;
use App\Http\Controllers\GameImgController;
use App\Http\Controllers\GameWordController;
use App\Http\Controllers\CustomGameImgController;
use App\Http\Controllers\CustomGameWordController;
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


Route::post('/register', [JWTAuthController::class,'register'])->name('api.jwt.register'); // JWT 회원가입

Route::post('/login', [JWTAuthController::class,'login'])->name('api.jwt.login'); // JWT 로그인 (최초토큰발행)

Route::get('community',[PostController::class,'index'])->name('community.index'); // 게시판 목록 라우팅

Route::get('qna',[QnaController::class,'index'])->name('qna.index'); // qna게시판 목록 라우팅
Route::post('refresh', [JWTAuthController::class,'refresh'])->name('api.jwt.refresh'); // 토큰재발행







Route::get('unauthorized', function() { // 인증실패에러
    return response()->json([
        'status' => 'error',
        'message' => 'Unauthorized'
    ], 401);
})->name('api.jwt.unauthorized');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user', [JWTAuthController::class,'user'])->name('api.jwt.user'); // 유저 정보 가져오기
    
    Route::get('logout', [JWTAuthController::class,'logout'])->name('api.jwt.logout'); // 로그아웃
    Route::post('auth', [JWTAuthController::class,'authenticate'])->name('api.jwt.authenticate'); // 토큰인증

    
    //Route::get('community',[PostController::class,'index'])->name('community.index'); // 게시판 목록 라우팅
    Route::post('community/store',[PostController::class,'store'])->name('community.store'); // 작성글 DB에 추가 ( Create )
    Route::get('community/{id}',[PostController::class,'show'])->name('community.show'); // 글 상세보기 ( Read )
    Route::post('community/{id}',[PostController::class,'update'])->name('community.update'); // 글 수정 ( Update )
    Route::delete('community/{id}', [PostController::class, 'destroy'])->name('community.destroy'); // 글 삭제 ( Delete )

    //Route::get('qna',[QnaController::class,'index'])->name('qna.index'); // qna게시판 목록 라우팅
    Route::post('qna/store',[QnaController::class,'store'])->name('qna.store'); // 작성글 DB에 추가 ( Create )
    Route::get('qna/{id}',[QnaController::class,'show'])->name('qna.show'); // 글 상세보기 ( Read )
    Route::post('qna/{id}',[QnaController::class,'update'])->name('qna.update'); // 글 수정 ( Update )
    Route::delete('qna/{id}', [QnaController::class, 'destroy'])->name('qna.destroy'); // 글 삭제 ( Delete )

    Route::get('items',[ItemController::class,'index'])->name('item.index'); // 상품 목록 라우팅
    Route::post('items/store',[ItemController::class,'store'])->name('item.store'); // 상품 추가 (Create)
    Route::get('items/{id}',[ItemController::class,'show'])->name('item.show'); // 상품 상세보기 ( Read )
    Route::post('items/{id}',[ItemController::class,'update'])->name('item.update'); // 상품 수정 ( Update )
    Route::delete('items/{id}',[ItemController::class,'destroy']); // 상품 삭제 (Delete)

    Route::post('/comments/store', [CommentController::class,'store'])->name('comment.add'); // 댓글 저장 Create
    Route::delete('/comments/{comment_id}', [CommentController::class, 'destroy'])->name('comment.destroy'); // 댓글 삭제

    Route::post('/answers/store', [QnaAnswerController::class,'store'])->name('answer.add'); // qna 답변 저장 Create
    Route::delete('/answers/{comment_id}', [QnaAnswerController::class, 'destroy'])->name('answer.destroy'); // 댓글 삭제

    Route::post('/reviews/store', [ReviewController::class,'store'])->name('review.add'); // 상품 리뷰 저장 Create
    Route::delete('/reviews/{comment_id}', [ReviewController::class, 'destroy'])->name('review.destroy'); // 상품 리뷰 삭제

    Route::get('/score',[ScoreboardController::class,'index'])->name('scorebaord.index'); // 자기 게임 점수 기록 목록
    Route::post('/score/store',[ScoreboardController::class,'store'])->name('scorebaord.store'); // 게임 점수 저장
    Route::delete('/score/{id}',[ScoreboardController::class,'destroy'])->name('scorebaord.destroy'); // 게임 점수 기록 삭제

    Route::get('gameimg/{id}',[GameImgController::class,'index'])->name('gameimg.index'); // 게임별 이미지 목록
    Route::post('gameimg/store',[GameImgController::class,'store'])->name('gameimg.store'); // 게임 이미지 저장
    Route::delete('gameimg/{id}/destroy',[GameImgController::class,'destroy'])->name('gameimg.destroy'); // 게임 이미지 삭제제

    Route::get('gameword/{id}',[GameWordController::class,'index'])->name('gameword.index'); // 게임별 단어 목록
    Route::post('gameword/store',[GameWordController::class,'store'])->name('gameword.store'); // 게임 단어 저장
    Route::delete('gameword/{id}/destroy',[GameWordController::class,'destroy'])->name('gameword.destroy'); // 게임 단어 삭제

    Route::get('customgameimg/{id}',[CustomGameImgController::class,'index'])->name('customgameimg.index'); // 게임별 커스텀 이미지 목록
    Route::post('customgameimg/store',[CustomGameImgController::class,'store'])->name('customgameimg.store'); // 게임 커스텀 이미지 저장
    Route::delete('customgameimg/{id}',[CustomGameImgController::class,'destroy'])->name('customgameimg.destroy'); // 게임 커스텀 이미지 삭제

    Route::get('customgameword/{id}',[CustomGameWordController::class,'index'])->name('customgameword.index'); // 게임별 단어 목록
    Route::post('customgameword/store',[CustomGameWordController::class,'store'])->name('customgameword.store'); // 게임 단어 저장
    Route::delete('customgameword/{id}/destroy',[CustomGameWordController::class,'destroy'])->name('customgameword.destroy'); // 게임 단어 삭제


    
});