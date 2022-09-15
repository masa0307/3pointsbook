<?php

namespace App\Http\Middleware;

use App\Models\Memo;
use Closure;
use Illuminate\Http\Request;

class CheckEditBookMemo
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
        if($store_memo){
            return $next($request);
        }else{
            return redirect()->route('book-memo.show', ['id'=>$request->id])->withErrors(['none_before_reading_content'=>'※読書前欄に記載がありません']);
        }
    }
}
