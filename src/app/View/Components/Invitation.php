<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Invitation extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $invitee_user_name;
    public $invtee_group_name;

    public function __construct($inviteeUserName, $invteeGroupName)
    {
        $this->invitee_user_name = $inviteeUserName;
        $this->invtee_group_name = $invteeGroupName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.invitation');
    }

}
