<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    //
    public function index(){
        return view('book-memo.index');
    }

    public function create($id){
        return view('book-memo.create', compact('id'));
    }

    public function store(Request $request){
        $store_book_memo = new Memo;
        $store_book_memo->before_reading_content = $request->before_reading_content;
        $store_book_memo->reading_content = $request->reading_content;
        $store_book_memo->after_reading_content = $request->after_reading_content;
        $store_book_memo->user_id = Auth::id();
        $store_book_memo->book_id = $request->book_id;
        $store_book_memo->save();
        return redirect()->route('book-memo.index');
    }
}
