<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\GameWord;

class GameWordController extends Controller
{
    public function index($id) // 게임별 단어 목록
    {  
        
        $words = GameWord::OrderBy('created_at', 'desc')->where('game_id', $id)->get();
        
       
        $returnJson = json_encode($words);

        return $returnJson;
    }

    public function store(Request $request) // 단어 저장
    {   
        request() -> validate([
            'game_id' => 'required', 
            'word' => 'required',                   
        ]);

        $values = request(['game_id','word']);

    
        $post = GameWord::create($values);
        
        return response()->json([
            'status' => 'success',
            'message' => 'word added'
        ], 200);
    
    }

    public function destroy($id){ // 단어 삭제
        $pocket = GameWord::where('id', $id) -> first();
        $pocket -> delete();

        
        return response()->json([
            'status' => 'success',
            'message' => 'word deleted'
        ], 200);
    }
    
}