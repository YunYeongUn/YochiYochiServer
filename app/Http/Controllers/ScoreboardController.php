<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scoreboard;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ScoreboardController extends Controller
{
    public function index() // 내 기록 목록 보기
    {  
        
        $scores = Scoreboard::OrderBy('created_at', 'desc')->where('user_id', Auth::guard('api')->user()->id)->with(
            [
                'users'=>function($query){
                    $query->select(['name','id']);
                }
            ])->get();
       
        $returnJson = json_encode($scores);

        return $returnJson;
    }

    public function store(Request $request) // 기록 저장  
    {   
        request() -> validate([
            'game_id' => 'required',
            'score'  => 'required',  
        ]);

        $values = request(['post_title', 'post_content']);
        $values['user_id'] = Auth::guard('api')->user()->id;
    
        $post = Scoreboard::create($values);
        
        return response()->json([
            'status' => 'success',
            'message' => 'written'
        ], 200);  
    }

    public function destroy($id){ // 기록 삭제
        $pocket = Scoreboard::where('id', $id) -> first();
        $pocket -> delete();

        return response()->json([
            'status' => 'success',
            'message' => 'deleted'
        ], 200);
    }

    
}