<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    //
    public function index($id){
        $store_book_memo  = Memo::where('book_id',$id)->first();
        if($store_book_memo ){
            $before_reading_content = $store_book_memo ->before_reading_content;
            $reading_content = $store_book_memo ->reading_content;
            $after_reading_content = $store_book_memo ->after_reading_content;
        }else{
            $before_reading_content = null;
            $reading_content = null;
            $after_reading_content = null;
        }

        return view('book-memo.index',  compact('before_reading_content','reading_content','after_reading_content', 'id'));
    }

    public function create($id){
        $store_book_memo  = Memo::where('book_id',$id)->first();
        if($store_book_memo ){
            $before_reading_content = $store_book_memo ->before_reading_content;
            $reading_content = $store_book_memo ->reading_content;
            $after_reading_content = $store_book_memo ->after_reading_content;
        }else{
            $before_reading_content = null;
            $reading_content = null;
            $after_reading_content = null;
        }

        return view('book-memo.create',  compact('before_reading_content','reading_content','after_reading_content', 'id'));
    }

    public function store(Request $request){
        $store_book_memo = Memo::where('book_id',$request->book_id)->first();
        if($request->before_reading_content){
            $store_book_memo = new Memo;
            $store_book_memo->before_reading_content = $request->before_reading_content;
        }elseif($request->reading_content){
            $store_book_memo->reading_content = $request->reading_content;
        }elseif($request->after_reading_content){
            $store_book_memo->after_reading_content = $request->after_reading_content;
        }
        $store_book_memo->user_id = Auth::id();
        $store_book_memo->book_id = $request->book_id;
        $store_book_memo->save();

        return redirect()->route('book-memo.index', ['id'=>$store_book_memo->book_id]);
    }

    public function update(Request $request){
        $store_book_memo = Memo::where('book_id',$request->book_id)->first();
        if($request->before_reading_content){
            $store_book_memo->before_reading_content = $request->before_reading_content;
        }elseif($request->reading_content){
            $store_book_memo->reading_content = $request->reading_content;
        }elseif($request->after_reading_content){
            $store_book_memo->after_reading_content = $request->after_reading_content;
        }
        $store_book_memo->save();

        return redirect()->route('book-memo.index', ['id'=>$store_book_memo->book_id]);
    }

}
