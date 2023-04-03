<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Answer;
use App\Models\Qna;
use App\Models\User;


class QnaAnswerController extends Controller
{
    public function store(Request $request){ // 댓글 작성 Create
        $validator = Validator::make(request()->all(), [
            'qna_id' => 'required',
            'comment' => 'required|max:255'
        ]);

        // 관리자인지 한번 더 체크 -------------------- 
        $whoRU = User::where('id',auth() -> id()) -> first();

        $admincheck = $whoRU->authority;
        if($admincheck == 'admin'){
            $RUadmin = Qna::where('id',request() -> qna_id) -> first();
            $RUadmin -> answer = 1;
            $RUadmin -> save();
            
            Answer::create([
                'qna_id' => request() -> qna_id,
                'comment' => request() -> comment
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Answer Stored'
            ], 200);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'only Admin can answer this QnA'
        ], 200);
        // ---------------------------

        
        
    }

    public function destroy($answer_id){ // 댓글 삭제 Delete
        

        // 관리자인지 체크 --------------------------------------
        $whoRU = User::where('id',auth() -> id()) -> first();

        $admincheck = $whoRU->authority;
        if($admincheck == 'admin'){
            
            $pocket = Answer::where('id', $answer_id) -> first();
            $pocket -> delete();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Answer Stored'
            ], 200);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'only Admin can delete this QnA'
        ], 200);
        //-----------------------------------------
    }
}