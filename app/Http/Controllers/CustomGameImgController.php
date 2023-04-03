<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomImg;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CustomGameImgController extends Controller
{
    public function index($id) // 자신이 저장한 게임별 커스텀 이미지 목록
    {  
        
        $imgs = CustomImg::OrderBy('created_at', 'desc')->where('game_id', $id)->where('user_id',Auth::guard('api')->user()->id)->get();
 
        $imgs->map(function($img) use ($imgPath) {
            $img->imgpath = $imgPath.'/images/'.$img->imgpath;
            return $img;
        });

        return $imgs;
    }

    public function store(Request $request) // 이미지 저장  
    {   
        $validatedData = $request->validate([
            'game_id' => 'required', 
            'attachment' => 'nullable|image|mimetypes:image/jpeg,image/png,image/gif,image/svg+xml',                   
        ]);
    
        $values = request(['game_id']);
        $values['user_id'] = auth()->id();
    
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/images', $fileName);
            $values['attachment'] = $fileName;
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No image file found.'
            ], 400);
        }
    
        $img = CustomImg::create($values);
    
        return response()->json([
            'status' => 'success',
            'message' => 'The image has been uploaded successfully.',
            'data' => [
                'img' => $img
            ]
        ], 201);
    }

    public function destroy($id){ // 이미지 삭제

        $pocket = CustomImg::where('id', $id) -> first();
        $pocket -> delete();


        return response()->json([
            'status' => 'success',
            'message' => 'deleted'
        ], 200);
    }
}