<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomWord;
use Illuminate\Support\Facades\Auth;

class CustomGameWordController extends Controller
{
    public function index($id) // 자신이 저장한 게임별 커스텀 단어 목록
    {  
        
        $words = CustomWord::OrderBy('created_at', 'desc')->where('game_id', $id)->where('user_id',Auth::guard('api')->user()->id)->get();
 
        $returnJson = json_encode($words);

        return $returnJson;
    }

    public function store(Request $request) // 이미지 저장  
    {   
        $validatedData = $request->validate([
            'game_id' => 'required', 
            'word' => 'required',                   
        ]);
    
        $values = request(['game_id','word']);
        $values['user_id'] = auth()->id();
    
        $word = CustomWord::create($values);
    
        return response()->json([
            'status' => 'success',
            'message' => 'The word has been uploaded successfully.',
            
        ], 201);
    }

    public function destroy($id){ // 이미지 삭제

        $pocket = CustomWord::where('id', $id) -> first();
        $pocket -> delete();

        return response()->json([
            'status' => 'success',
            'message' => 'deleted'
        ], 200);
    }
}