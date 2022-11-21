<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SpHiddenSearchMemoList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sp-hidden-search-memo-list');
    }
}
