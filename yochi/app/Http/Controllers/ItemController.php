<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Category;


class ItemController extends Controller
{
    public function index() // 상품목록
    {  
        
        $items = Item::OrderBy('created_at', 'desc')->get();
        
       
        $returnJson = json_encode($items);
       

        return $returnJson;
    }

    public function store(Request $request) // 상품 저장`  
    {   
        request() -> validate([
            'item_title' => 'required',
            'item_content'  => 'required',  
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',                   
        ]);

        $values = request(['item_title', 'item_content']);
        $values['writer'] = auth() -> id();

        if($request -> hasFile('attachment')){  
            
            $fileName = time().'_'.$request -> file('attachment') -> getClientOriginalName();
            $path = $request -> file('attachment') -> storeAs('/public/images', $fileName);
            $values['attachment'] = $fileName;

        }
        
        
        $item = Item::create($values);
        $id = $item->id;

        return $id;
    }

    public function show($id) // 상품 상세보기 Read & 댓그 목록
    {
        $pocket = Item::where('id',$id)->first();
        
        $imgPath = asset('storage');
        
        $returnJson2 = [
            $pocket,
            $imgPath
        ];

        return $returnJson2;
    }

    public function update(Request $request, $id){ // 상품 수정
        $validation = $request -> validate([
            'item_title' => 'required',
            'item_content' => 'required'
        ]);

        $pocket = Item::where('id', $id) -> first();
        $pocket -> item_title = $validation['item_title'];
        $pocket -> item_content = $validation['item_content'];
        $pocket -> save();

        return $id;
    }

    public function destroy($id){ // 상품 삭제
        $pocket = Item::where('id', $id) -> first();
        $pocket -> delete();
    }
}