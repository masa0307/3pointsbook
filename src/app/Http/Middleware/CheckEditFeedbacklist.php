<?php

namespace App\Http\Middleware;

use App\Models\Memo;
use Closure;
use Illuminate\Http\Request;

class CheckEditFeedbacklist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $store_memo = Memo::where('book_id',$request->id)->first();
        if(!$store_memo){
            return redirect()->route('feedback-list.show', ['id'=>$request->id])->withErrors(['none_book_memo'=>'※読書メモが保存されていません']);
        }else if(!$store_memo->actionlist1_content){
            return redirect()->route('feedback-list.show', ['id'=>$request->id])->withErrors(['none_action_list'=>'※アクションリストが保存されていません']);
        }else{
            return $next($request);
        }
    }
}
