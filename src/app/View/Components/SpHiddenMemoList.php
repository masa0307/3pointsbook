<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SpHiddenMemoList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $books_reading;

    public $books_interesting;

    public $memo_groups;

    public function __construct($booksReading, $booksInteresting, $memoGroups)
    {
        $this->books_reading = $booksReading;
        $this->books_interesting = $booksInteresting;
        $this->memo_groups = $memoGroups;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sp-hidden-memo-list');
    }
}
