<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemoGroupRequest;
use App\Models\GroupUser;
use App\Models\MemoGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemoGroupController extends Controller
{
    public function create(){
        return view('group.create');
    }

    public function store(MemoGroupRequest $request){
        $group = new MemoGroup;
        $group->group_name = $request->group_name;
        $group->save();

        session()->put(['group' => $group]);

        $group_user = new GroupUser;
        $group_user->group_id = $group->id;
        $group_user->user_id = Auth::id();
        $group_user->is_owner = true;
        $group_user->participation_status = "参加中";
        $group_user->save();

        session()->put(['group_name' => $group->group_name]);

        return redirect()->route('group-user.search');
    }
}
