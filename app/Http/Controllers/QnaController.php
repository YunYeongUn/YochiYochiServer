<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qna;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Answer;
use App\Http\Controllers\QnaAnswerController;

class QnaController extends Controller
{
    public function index() // 게시판목록
    {  
        
        $posts = Qna::OrderBy('created_at', 'desc')->with( 'users:id,name')->get();
        

        return $posts;
    }


    public function store(Request $request) // 작성글 저장`  
    {   
        request() -> validate([
            'qna_title' => 'required',
            'qna_content'  => 'required',
            'category' => 'required',  
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',                   
        ]);

        $values = request(['qna_title', 'qna_content','category']);
        $values['writer'] = auth() -> id();


        if($request -> hasFile('attachment')){  
            
            $fileName = time().'_'.$request -> file('attachment') -> getClientOriginalName();
            $path = $request -> file('attachment') -> storeAs('/public/images', $fileName);
            $values['attachment'] = $fileName;

        }
    
        $post = Qna::create($values);
        
        return response()->json([
            'status' => 'success',
            'message' => 'written'
        ], 200);
        
    }

    public function show($id) // 글 상세보기 Read & 댓그 목록
    {
        $pocket = Qna::where('id',$id)->with(
            [
                'users'=>function($query){
                    $query->select(['name','id']);
                }
            ])->first();

        $Answerpocket = Answer::where('qna_id',$id)->OrderBy('created_at','desc')->first()->get(); 
        

        $imgPath = asset('storage');
        $pocket->attachment = $imgPath.'/images/'.$pocket->attachment;

        $returnJson2 = [
            $pocket,
            $Answerpocket,
        ];

        return $returnJson2;
    }



    public function update(Request $request, $id){ // 글 수정
        $validation = $request -> validate([
            'qna_title' => 'required',
            'qna_content' => 'required'
        ]);

        $pocket = Qna::where('id', $id) -> first();
        $pocket -> qna_title = $validation['qna_title'];
        $pocket -> qna_content = $validation['qna_content'];
        $pocket -> save();

       
        return response()->json([
            'status' => 'success',
            'message' => 'updated'
        ], 200);
    }

    public function destroy($id){ // 글 삭제
        $pocket = Qna::where('id', $id) -> first();
        $pocket -> delete();

        
        return response()->json([
            'status' => 'success',
            'message' => 'deleted'
        ], 200);
    }
}