<?php

namespace App\Http\ViewComposers;

use App\Models\Book;
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
        $view->with([
            'books'   => Book::all(),
        ]);
    }
}
