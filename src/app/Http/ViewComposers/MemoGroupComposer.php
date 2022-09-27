<?php

namespace App\Http\ViewComposers;

use App\Models\MemoGroup;
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
            'groups'   => MemoGroup::all(),
        ]);
    }
}
