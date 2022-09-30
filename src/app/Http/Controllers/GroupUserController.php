<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupUserRequest;
use App\Models\GroupUser;
use App\Models\MemoGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupUserController extends Controller
{
    public function search(){
        if(session('search_user')){
            session()->forget('search_user');
        }

        $group_users = GroupUser::where('group_id', session('group')->id)->get();

        return view('group-user.search', compact('group_users'));
    }

    public function searchResult(GroupUserRequest $request){
        if(session('search_user')){
            session()->forget('search_user');
        }

        $group_user = $request->name;

        if ($group_user) {
            $space_conversioned_group_user = mb_convert_kana($group_user, 's');
            $search_user = User::where('name', $space_conversioned_group_user)->first();
            session()->put(['search_user' => $search_user]);
        }

        return view('group-user.search');
    }

    public function store(GroupUserRequest $request){
        $group_user = new GroupUser;
        $group_user->group_id             = session('group')->id;
        $group_user->user_id              = $request->user_id;
        $group_user->is_owner             = false;
        $group_user->participation_status = "招待中";
        $group_user->save();

        return redirect()->route('group-user.search');
    }

    public function update(Request $request){
        $memo_groups = User::find(Auth::id())->memogroup;
        foreach ($memo_groups as $memo_group){
            if($memo_group->pivot->participation_status == '招待中'){
                $group_user = GroupUser::where('user_id', Auth::id())->where('group_id', $memo_group->id)->first();
                $group_user->participation_status = $request->participation_status;
                $group_user->save();

                return redirect()->route('book.index');
            }
        }
    }

    public function destroy(Request $request){
        $memo_groups = User::find(Auth::id())->memogroup;
        foreach ($memo_groups as $memo_group){
            if($memo_group->pivot->participation_status == '招待中'){
                $group_user = GroupUser::where('user_id', Auth::id())->where('group_id', $memo_group->id)->first();
                $group_user->delete();

                return redirect()->route('book.index');
            }
        }
    }

    public function add($id){
        session()->put(['group' =>MemoGroup::find($id) ]);
        $group_users = GroupUser::where('group_id', $id)->get();
        $group_name = MemoGroup::find($id)->group_name;

        return view('group-user.add', compact('group_users', 'group_name'));
    }
}
