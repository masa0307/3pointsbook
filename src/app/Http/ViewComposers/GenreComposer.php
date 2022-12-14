<?php

namespace App\Http\ViewComposers;

use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class UserComposer
 * @package App\Http\ViewComposers
 */
class GenreComposer
{

    /**
     * Bind data to the view.
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'genres'   => Genre::where('user_id', Auth::id())->get(),
        ]);
    }
}
