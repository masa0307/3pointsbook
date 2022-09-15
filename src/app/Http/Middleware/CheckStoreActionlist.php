<?php

namespace App\Http\Middleware;

use App\Models\Memo;
use Closure;
use Illuminate\Http\Request;

class CheckStoreActionlist
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
        if($request->actionlist1_content){
            return $next($request);
        }else{
            return redirect()->route('action-list.show', ['id'=>$request->book_id])->withErrors(['none_actionlist1_content'=>'※アクションリスト１が記載されていません']);
        }
    }
}
