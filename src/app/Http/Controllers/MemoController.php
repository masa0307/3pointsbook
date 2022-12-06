<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemoRequest;
use App\Models\Book;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    //
    public function show($id){
        $store_memo = Memo::where('book_id',$id)->first();
        $select_book = Book::where('id',$id)->first();

        if($store_memo ){
            $is_store_memo = true;
        }else{
            $is_store_memo = false;
        }

        return view('memo.show', compact('store_memo', 'is_store_memo', 'id', 'select_book'));
    }

    public function edit($id){
        $store_memo = Memo::where('book_id',$id)->first();
        $select_book = Book::where('id',$id)->first();

        session()->forget('is_edit');

        if($store_memo ){
            $is_store_memo = true;
        }else{
            $is_store_memo = false;
        }

        return view('memo.edit', compact('store_memo', 'is_store_memo', 'id', 'select_book'));
    }

    public function store(MemoRequest $request){
        $store_memo = Memo::where('book_id',$request->book_id)->first();

        if($request->before_reading_content){
            $store_memo = new Memo;
            $store_memo->before_reading_content = $request->before_reading_content;
        }elseif($request->reading_content){
            $store_memo->reading_content        = $request->reading_content;
        }elseif($request->after_reading_content){
            $store_memo->after_reading_content  = $request->after_reading_content;
        }elseif($request->actionlist1_content){
            $store_memo->actionlist1_content    = $request->actionlist1_content;
            $store_memo->actionlist2_content    = $request->actionlist2_content;
            $store_memo->actionlist3_content    = $request->actionlist3_content;
        }elseif($request->feedback1_content){
            $store_memo->feedback1_content      = $request->feedback1_content;
            $store_memo->feedback2_content      = $request->feedback2_content;
            $store_memo->feedback3_content      = $request->feedback3_content;
        }
        $store_memo->user_id = Auth::id();
        $store_memo->book_id = $request->book_id;
        $store_memo->save();
        session()->put(['is_edit' => true]);

        if($request->before_reading_content || $request->reading_content || $request->after_reading_content){
            return redirect()->route('book-memo.show', [$store_memo->book_id, str_replace('?', '', mb_strstr(url()->previous(), '?'))]);
        }elseif($request->actionlist1_content || $request->actionlist2_content || $request->actionlist3_content){
            return redirect()->route('action-list.show', [$store_memo->book_id, str_replace('?', '', mb_strstr(url()->previous(), '?'))]);
        }elseif($request->feedback1_content || $request->feedback2_content || $request->feedback3_content){
            return redirect()->route('feedback-list.show', [$store_memo->book_id, str_replace('?', '', mb_strstr(url()->previous(), '?'))]);
        }
    }

    public function update(MemoRequest $request){
        $store_memo = Memo::where('book_id',$request->id)->first();

        if($request->before_reading_content){
            $store_memo->before_reading_content = $request->before_reading_content;
        }elseif($request->reading_content){
            $store_memo->reading_content        = $request->reading_content;
        }elseif($request->after_reading_content){
            $store_memo->after_reading_content  = $request->after_reading_content;
        }elseif($request->actionlist1_content){
            $store_memo->actionlist1_content    = $request->actionlist1_content;
            $store_memo->actionlist2_content    = $request->actionlist2_content;
            $store_memo->actionlist3_content    = $request->actionlist3_content;
        }elseif($request->feedback1_content){
            $store_memo->feedback1_content      = $request->feedback1_content;
            $store_memo->feedback2_content      = $request->feedback2_content;
            $store_memo->feedback3_content      = $request->feedback3_content;
        }

        $store_memo->save();
        session()->put(['is_edit' => true]);

        if($request->before_reading_content || $request->reading_content || $request->after_reading_content){
            return redirect()->route('book-memo.show', [$store_memo->book_id, str_replace('?', '', mb_strstr(url()->previous(), '?'))]);
        }elseif($request->actionlist1_content || $request->actionlist2_content || $request->actionlist3_content){
            return redirect()->route('action-list.show', [$store_memo->book_id, str_replace('?', '', mb_strstr(url()->previous(), '?'))]);
        }elseif($request->feedback1_content || $request->feedback2_content || $request->feedback3_content){
            return redirect()->route('feedback-list.show', [$store_memo->book_id, str_replace('?', '', mb_strstr(url()->previous(), '?'))]);
        }
    }

}
