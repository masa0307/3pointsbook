<?php

namespace App\Http\ViewComposers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
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
                'books_reading'   => Book::where('user_id', Auth::id())->where('state', '読書中')->paginate(3, ['*'], 'bookReadingPage')->appends(['groupPage' => \Request::get('groupPage'), 'bookInterestingPage' => \Request::get('bookInterestingPage')]),
                'books_interesting'   => Book::where('user_id', Auth::id())->where('state', '気になる')->paginate(3, ['*'], 'bookInterestingPage')->appends(['groupPage' => \Request::get('groupPage'), 'bookReadingPage' => \Request::get('bookReadingPage')]),
            ]);
        }else if(User::find(Auth::id())->sort_name == '追加順（降順）'){
            $view->with([
                'books_reading'   => Book::where('user_id', Auth::id())->where('state', '読書中')->orderBy('id','desc')->paginate(3, ['*'], 'bookReadingPage')->appends(['groupPage' => \Request::get('groupPage'), 'bookInterestingPage' => \Request::get('bookInterestingPage')]),
                'books_interesting'   => Book::where('user_id', Auth::id())->where('state', '気になる')->orderBy('id','desc')->paginate(3, ['*'], 'bookInterestingPage')->appends(['groupPage' => \Request::get('groupPage'), 'bookReadingPage' => \Request::get('bookReadingPage')]),
            ]);
        }else if(User::find(Auth::id())->sort_name == 'タイトル順（昇順）'){
            $view->with([
                'books_reading'   => Book::where('user_id', Auth::id())->where('state', '読書中')->orderBy('title_kana')->paginate(3, ['*'], 'bookReadingPage')->appends(['groupPage' => \Request::get('groupPage'), 'bookInterestingPage' => \Request::get('bookInterestingPage')]),
                'books_interesting'   => Book::where('user_id', Auth::id())->where('state', '気になる')->orderBy('title_kana')->paginate(3, ['*'], 'bookInterestingPage')->appends(['groupPage' => \Request::get('groupPage'), 'bookReadingPage' => \Request::get('bookReadingPage')]),
            ]);
        }else if(User::find(Auth::id())->sort_name == 'タイトル順（降順）'){
            $view->with([
                'books_reading'   => Book::where('user_id', Auth::id())->where('state', '読書中')->orderBy('title_kana','desc')->paginate(3, ['*'], 'bookReadingPage')->appends(['groupPage' => \Request::get('groupPage'), 'bookInterestingPage' => \Request::get('bookInterestingPage')]),
                'books_interesting'   => Book::where('user_id', Auth::id())->where('state', '気になる')->orderBy('title_kana','desc')->paginate(3, ['*'], 'bookInterestingPage')->appends(['groupPage' => \Request::get('groupPage'), 'bookReadingPage' => \Request::get('bookReadingPage')]),
            ]);
        }
    }
}
