<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NoticeController extends Controller
{
    public function index() // 공지사항 목록
    {  
        
        $posts = Notice::OrderBy('created_at', 'desc')->get();
        
        $returnJson = json_encode($posts);

        return $returnJson;
    }

    public function store(Request $request) // 공지사항 저장
    {   
        request() -> validate([
            'notice_title' => 'required',
            'notice_content'  => 'required',
            'category' => 'required',  
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',                   
        ]);

        $values = request(['notice_title', 'notice_content','category']);


        if($request -> hasFile('attachment')){  
            
            $fileName = time().'_'.$request -> file('attachment') -> getClientOriginalName();
            $path = $request -> file('attachment') -> storeAs('/public/images', $fileName);
            $values['attachment'] = $fileName;

        }
    
        $post = Notice::create($values);
        
        return response()->json([
            'status' => 'success',
            'message' => 'notice written'
        ], 200);
        
    }

    public function show($id) // 글 상세보기 Read & 답변 목록
    {
        $pocket = Notice::where('id',$id)->first();

        

        $imgPath = asset('storage');

        $pocket->attachment = $imgPath.'/images/'.$pocket->attachment;
        $returnJson2 = [
            $pocket,
        ];

        return $returnJson2;
    }

    public function update(Request $request, $id){ // 글 수정
        $validation = $request -> validate([
            'notice_title' => 'required',
            'notice_content' => 'required'
        ]);

        $pocket = Notice::where('id', $id) -> first();
        $pocket -> notice_title = $validation['notice_title'];
        $pocket -> notice_content = $validation['notice_content'];
        $pocket -> save();

       
        return response()->json([
            'status' => 'success',
            'message' => 'notice updated'
        ], 200);
    }

    public function destroy($id){ // 글 삭제
        $pocket = Notice::where('id', $id) -> first();
        $pocket -> delete();

        
        return response()->json([
            'status' => 'success',
            'message' => 'notice deleted'
        ], 200);
    }
}