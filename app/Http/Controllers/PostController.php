<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Comment;
use Inertia\Inertia;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Redirect;


class PostController extends Controller
{
    
    //
    public function index(Request $request) // 게시판목록
    {  
        
        $perPage = 10; // 한 페이지에 보여줄 게시글 수
        $page = $request->input('page', 1); // URL 쿼리 파라미터로부터 페이지 번호를 가져옴

        // $posts = Post::OrderBy('created_at', 'desc')->with( 
        //     'users:id,name')->paginate($perPage, ['*'], 'page', $page);

        // $posts = Post::OrderBy('created_at', 'desc')->with(
        //     [
        //         'users'=>function($query){
        //             $query->select(['name','id']);
        //         }
        //     ])->get();
        
        $posts = Post::OrderBy('created_at', 'desc')->with( 'users:id,name')->get();
        

        return $posts;
    }


    public function store(Request $request) // 작성글 저장`  
    {   
        request() -> validate([
            'post_title' => 'required',
            'post_content'  => 'required',  
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',                   
        ]);

        $values = request(['post_title', 'post_content']);
        $values['writer'] = auth() -> id();

        if($request -> hasFile('attachment')){  
            
            $fileName = time().'_'.$request -> file('attachment') -> getClientOriginalName();
            $path = $request -> file('attachment') -> storeAs('/public/images', $fileName);
            $values['attachment'] = $fileName;

        }
    
        $post = Post::create($values);

        return response()->json([
            'status' => 'success',
            'message' => 'written'
        ], 200);
        
    }

    public function show($id) // 글 상세보기 Read & 댓그 목록
    {
        $pocket = Post::where('id',$id)->with(
            [
                'users'=>function($query){
                    $query->select(['name','id']);
                }
            ])->first();
        // 조회수증가
        $pocket -> views +=1;
        $pocket -> save();
        //-----------
        $commentpocket = Comment::where('post_id',$id)->OrderBy('created_at','desc')->with(
            [
                'users'=>function($query){
                    $query->select(['name','id']);
                }
            ])->get(); 
        

        $imgPath = asset('storage');
        $pocket->attachment = $imgPath.'/images/'.$pocket->attachment;
        
        $returnJson2 = [
            $pocket,
            $commentpocket,
        ];

        return $returnJson2;
    }

    public function update(Request $request, $id){ // 글 수정
        $validation = $request -> validate([
            'post_title' => 'required',
            'post_content' => 'required'
        ]);

        $pocket = Post::where('id', $id) -> first();
        $pocket -> post_title = $validation['post_title'];
        $pocket -> post_content = $validation['post_content'];
        $pocket -> save();

        // return redirect('/post/'.$board_id.'/'.$pocket->id); 
        return response()->json([
            'status' => 'success',
            'message' => 'updated'
        ], 200);
    }

    public function destroy($id){ // 글 삭제
        $pocket = Post::where('id', $id) -> first();
        $pocket -> delete();

        // return redirect('/post/'.$board_id);
        return response()->json([
            'status' => 'success',
            'message' => 'deleted'
        ], 200);
    }


    public function search(Request $request) // 글 검색
    {
        $searchTerm = $request->input('search');
        $perPage = 10; // 한 페이지에 보여줄 게시글 수
        $page = $request->input('page', 1); // URL 쿼리 파라미터로부터 페이지 번호를 가져옴

        $posts = Post::where('title', 'like', '%'.$searchTerm.'%')
                    ->orWhere('body', 'like', '%'.$searchTerm.'%')
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage, ['*'], 'page', $page);

        return $posts;
    }
}