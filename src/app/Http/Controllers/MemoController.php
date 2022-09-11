<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoController extends Controller
{
    //
    public function show($id){
        $store_book_memo  = Memo::where('book_id',$id)->first();
        if($store_book_memo ){
            $before_reading_content = $store_book_memo ->before_reading_content;
            $reading_content = $store_book_memo ->reading_content;
            $after_reading_content = $store_book_memo ->after_reading_content;
            $actionlist1_content = $store_book_memo ->actionlist1_content;
            $actionlist2_content = $store_book_memo ->actionlist2_content;
            $actionlist3_content = $store_book_memo ->actionlist3_content;
            $feedback1_content = $store_book_memo ->feedback1_content;
            $feedback2_content = $store_book_memo ->feedback2_content;
            $feedback3_content = $store_book_memo ->feedback3_content;
        }else{
            $before_reading_content = null;
            $reading_content = null;
            $after_reading_content = null;
            $actionlist1_content = null;
            $actionlist2_content = null;
            $actionlist3_content = null;
            $feedback1_content = null;
            $feedback2_content = null;
            $feedback3_content = null;
        }

        return view('memo.show',  compact('before_reading_content','reading_content','after_reading_content', 'actionlist1_content', 'actionlist2_content','actionlist3_content','feedback1_content', 'feedback2_content','feedback3_content','id'));
    }

    public function edit($id){
        $store_book_memo  = Memo::where('book_id',$id)->first();
        if($store_book_memo ){
            $before_reading_content = $store_book_memo ->before_reading_content;
            $reading_content = $store_book_memo ->reading_content;
            $after_reading_content = $store_book_memo ->after_reading_content;
            $actionlist1_content = $store_book_memo ->actionlist1_content;
            $actionlist2_content = $store_book_memo ->actionlist2_content;
            $actionlist3_content = $store_book_memo ->actionlist3_content;
            $feedback1_content = $store_book_memo ->feedback1_content;
            $feedback2_content = $store_book_memo ->feedback2_content;
            $feedback3_content = $store_book_memo ->feedback3_content;
        }else{
            $before_reading_content = null;
            $reading_content = null;
            $after_reading_content = null;
            $actionlist1_content = null;
            $actionlist2_content = null;
            $actionlist3_content = null;
            $feedback1_content = null;
            $feedback2_content = null;
            $feedback3_content = null;
        }

        return view('memo.edit',  compact('before_reading_content','reading_content','after_reading_content','actionlist1_content', 'actionlist2_content','actionlist3_content', 'feedback1_content', 'feedback2_content','feedback3_content','id'));
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
        }elseif($request->actionlist1_content){
            $store_book_memo->actionlist1_content = $request->actionlist1_content;
            $store_book_memo->actionlist2_content = $request->actionlist2_content;
            $store_book_memo->actionlist3_content = $request->actionlist3_content;
        }elseif($request->feedback1_content){
            $store_book_memo->feedback1_content = $request->feedback1_content;
            $store_book_memo->feedback2_content = $request->feedback2_content;
            $store_book_memo->feedback3_content = $request->feedback3_content;
        }
        $store_book_memo->user_id = Auth::id();
        $store_book_memo->book_id = $request->book_id;
        $store_book_memo->save();

        if($request->before_reading_content || $request->reading_content || $request->after_reading_content){
            return redirect()->route('book-memo.show', ['id'=>$store_book_memo->book_id]);
        }elseif($request->actionlist1_content || $request->actionlist2_content || $request->actionlist3_content){
            return redirect()->route('action-list.show', ['id'=>$store_book_memo->book_id]);
        }elseif($request->feedback1_content || $request->feedback2_content || $request->feedback3_content){
            return redirect()->route('feedback-list.show', ['id'=>$store_book_memo->book_id]);
        }
    }

    public function update(Request $request){
        $store_book_memo = Memo::where('book_id',$request->id)->first();
        if($request->before_reading_content){
            $store_book_memo->before_reading_content = $request->before_reading_content;
        }elseif($request->reading_content){
            $store_book_memo->reading_content = $request->reading_content;
        }elseif($request->after_reading_content){
            $store_book_memo->after_reading_content = $request->after_reading_content;
        }elseif($request->actionlist1_content){
            $store_book_memo->actionlist1_content = $request->actionlist1_content;
            $store_book_memo->actionlist2_content = $request->actionlist2_content;
            $store_book_memo->actionlist3_content = $request->actionlist3_content;
        }elseif($request->feedback1_content){
            $store_book_memo->feedback1_content = $request->feedback1_content;
            $store_book_memo->feedback2_content = $request->feedback2_content;
            $store_book_memo->feedback3_content = $request->feedback3_content;
        }
        $store_book_memo->save();

        if($request->before_reading_content || $request->reading_content || $request->after_reading_content){
            return redirect()->route('book-memo.show', ['id'=>$store_book_memo->book_id]);
        }elseif($request->actionlist1_content || $request->actionlist2_content || $request->actionlist3_content){
            return redirect()->route('action-list.show', ['id'=>$store_book_memo->book_id]);
        }elseif($request->feedback1_content || $request->feedback2_content || $request->feedback3_content){
            return redirect()->route('feedback-list.show', ['id'=>$store_book_memo->book_id]);
        }
    }

}
