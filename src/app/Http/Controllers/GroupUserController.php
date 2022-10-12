<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupUserRequest;
use App\Models\Book;
use App\Models\Genre;
use App\Models\GroupUser;
use App\Models\Memo;
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
        $invited_group_users = GroupUser::where('user_id', Auth::id())->where('participation_status', '招待中')->get();
        foreach ($invited_group_users as $count => $invited_group_user){

            if($count === 0){
                $invited_group_user->participation_status = $request->participation_status;
                $invited_group_user->save();
            }

            return redirect()->route('book.index');
        }

    }

    public function reject(Request $request){
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

    public function edit($id){
        $group_users = GroupUser::where('group_id', $id)->get();
        $group_name = MemoGroup::find($id)->group_name;

        return view('group-user.edit', compact('group_users', 'group_name'));
    }

    public function destroy($group_id, $user_id){
        $group_user = GroupUser::where('group_id', $group_id)->where('user_id', $user_id)->first();
        $deleted_group = MemoGroup::find($group_id);
        $group_user->delete();

        if(GroupUser::where('group_id', $group_id)->where('participation_status', '参加中')->get()->isNotEmpty()){
            return redirect()->route('group-user.edit', $group_id);
        }else{
            $deleted_group->delete();
            return redirect()->route('book.index');
        }

    }

    public function index($book_id, $group_id){
        $selectedBook = Book::where('id', $book_id)->first();
        $group_name = MemoGroup::find($group_id)->group_name;
        $users = User::all();

        if($selectedBook){
            $genre_name = $selectedBook->genre->genre_name;
            return view('group-user-memo.index', compact('selectedBook', 'genre_name', 'group_name', 'users'));
        }else{
            return view('group-user-memo.index', compact('selectedBook', 'users'));
        }
    }

    public function show($book_id, $group_id){
        $store_memo = Memo::where('book_id',$book_id)->first();
        $select_book = Book::where('id', $book_id)->first();
        $group_name = MemoGroup::find($group_id)->group_name;

        if($store_memo ){
            $is_store_memo = true;
        }else{
            $is_store_memo = false;
        }

        return view('group-user-memo.show', compact('store_memo', 'is_store_memo', 'select_book', 'book_id', 'group_id', 'group_name'));
    }

    public function showPublishStatus($book_id){
        if(!Genre::where('user_id', Auth::id())->first()){
            $genre = new Genre;
            $genre->user_id = Auth::id();
            $genre->save();

        }
        if(GroupUser::where('user_id', Auth::id())->where('participation_status', '招待中')->first()){
            $group_user = GroupUser::all();
        }else{
            $group_user=null;
        }

        $published_book = Book::find($book_id);
        $published_memos = $published_book->memo()->whereNotNull('group_id')->get();
        $belong_to_group_ids = [];
        $published_group_ids = [];

        foreach($published_memos as $published_memo){
            array_push($published_group_ids, $published_memo->group_id);
        }

        $group_users = GroupUser::where('user_id',Auth::id())->get();

        foreach($group_users as $group_user){
            array_push($belong_to_group_ids, $group_user->group_id);
        }

        $not_published_groups = MemoGroup::whereIn('id', $belong_to_group_ids)->whereNotIn('id', $published_group_ids)->get();
        $published_groups = MemoGroup::whereIn('id', $published_group_ids)->get();
        $genre_name = $published_book->genre->genre_name;

        return view('group-user-memo.publish-status', compact('published_book', 'genre_name', 'group_user', 'book_id', 'published_groups','not_published_groups'));
    }

    public function publish(Request $request){
        if($request->group_id){
            $published_memo = Book::find($request->id)->memo->where('group_id', null)->first();
            $memo = Book::find($request->id)->memo->first();

            if($published_memo){
                $published_memo->group_id = $request->group_id;
                $published_memo->save();
            }elseif(!$published_memo){
                $published_memo = $memo->replicate();
                $published_memo->group_id = $request->group_id;
                $published_memo->save();
            }

        }elseif($request->non_group_id){
            $published_memo = Book::find($request->id)->memo->where('group_id', $request->non_group_id)->first();
            $published_memo->group_id = null;
            $published_memo->save();
        }

        return redirect()->route('book.index');
    }
}
