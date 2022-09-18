<?php

namespace App\Http\ViewComposers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class UserComposer
 * @package App\Http\ViewComposers
 */
class BookComposer
{

    /**
     * Bind data to the view.
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        if(User::find(Auth::id())->sort_name == '追加順（昇順）'){
            $view->with([
                'books'   => Book::where('user_id', Auth::id())->get(),
            ]);
        }else if(User::find(Auth::id())->sort_name == '追加順（降順）'){
            $view->with([
                'books'   => Book::where('user_id', Auth::id())->orderBy('id','desc')->get(),
            ]);
        }else if(User::find(Auth::id())->sort_name == 'タイトル順（昇順）'){
            $view->with([
                'books'   => Book::where('user_id', Auth::id())->orderBy('title_kana')->get(),
            ]);
        }else if(User::find(Auth::id())->sort_name == 'タイトル順（降順）'){
            $view->with([
                'books'   => Book::where('user_id', Auth::id())->orderBy('title_kana','desc')->get(),
            ]);
        }
    }
}
