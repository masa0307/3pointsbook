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
    public $is_invited_group_users;
    public $invited_group_users;
    public $invitee_user_name;
    public $invtee_group_name;

    public function __construct($isInvitedGroupUsers, $invitedGroupUsers, $inviteeUserName, $invteeGroupName)
    {
        $this->is_invited_group_users = $isInvitedGroupUsers;
        $this->invited_group_users    = $invitedGroupUsers;
        $this->invitee_user_name      = $inviteeUserName;
        $this->invtee_group_name      = $invteeGroupName;
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
