<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStoreFeedbacklist
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
        if($request->feedback1_content){
            return $next($request);
        }else{
            return redirect()->route('feedback-list.show', ['id'=>$request->book_id])->withErrors(['none_feedback_list1_content'=>'※振り返り１が記載されていません']);
        }
    }
}
