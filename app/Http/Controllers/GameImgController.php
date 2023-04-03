<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gameimg;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class GameImgController extends Controller
{


    public function index(Request $request, $id)
    {  
        $perPage = 10; // 한 페이지에 보여줄 게임 이미지 수
        $page = $request->input('page', 1); // URL 쿼리 파라미터로부터 페이지 번호를 가져옴

        // 게임 ID에 해당하는 게임 이미지 목록을 페이지네이션하여 가져옴
        $imgs = GameImg::where('game_id', $id)->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        $imgPath = asset('storage');

        // 각 이미지 정보에 이미지 경로를 추가
        $imgs->map(function($img) use ($imgPath) {
            $img->imgpath = $imgPath.'/images/'.$img->imgpath;
            return $img;
        });

        return $imgs;
    }


    public function store($id,Request $request) // 이미지 저장  
    {   
        $whoRU = Auth::guard('api')->user()->authority;

        if ($whoRU != 'admin') { // 어드민체크
            return response()->json([
                'status' => 'error',
                'message' => 'Only admin can upload game images.'
            ], 401);
        }

        $validatedData = $request->validate([
            'game_id' => 'required', 
            'attachment' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml',                   
        ]);

        $values = request(['game_id']);
        $values['user_id'] = auth()->id();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/images', $fileName);
            $values['attachment'] = $fileName;
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No image file found.'
            ], 400);
        }

        $img = Gameimg::create($values);

        return response()->json([
            'status' => 'success',
            'message' => 'The game image has been uploaded successfully.',
            'data' => [
                'img' => $img
            ]
        ], 201);
    }

    public function destroy($id){ // 이미지 삭제

        $whoRU = Auth::guard('api')->user()->authority;

        if($whoRU != 'admin') return response()->json([ // 어드민체크
            'status' => 'error',
            'message' => 'Only admin can delete game img'
        ],401);

        $pocket = Gameimg::where('id', $id) -> first();
        $pocket -> delete();


        return response()->json([
            'status' => 'success',
            'message' => 'deleted'
        ], 200);
    }
}