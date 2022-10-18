<?php

namespace App\Http\ViewComposers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class UserComposer
 * @package App\Http\ViewComposers
 */
class MemoGroupComposer
{

    /**
     * Bind data to the view.
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'memo_groups' =>User::find(Auth::id())->memogroup()->paginate(2, ['*'], 'groupPage')->appends(['bookReadingPage' => \Request::get('bookReadingPage'), 'bookInterestingPage' => \Request::get('bookInterestingPage')])
        ]);
    }
}
