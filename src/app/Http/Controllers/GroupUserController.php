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
        $group_user->delete();

        if(GroupUser::where('group_id', $group_id)->get()->isNotEmpty()){
            return redirect()->route('group-user.edit', $group_id);
        }else{
            return redirect()->route('book.index');
        }

    }

    public function index($book_id, $group_id){
        $selectedBook = Book::where('id', $book_id)->first();
        $group_name = MemoGroup::find($group_id)->group_name;

        if($selectedBook){
            $genre_name = $selectedBook->genre->genre_name;
            return view('group-user-memo.index', compact('selectedBook', 'genre_name', 'group_name'));
        }else{
            return view('group-user-memo.index', compact('selectedBook'));
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

    public function showViewStatus($book_id){
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

        $viewed_book = Book::find($book_id);
        $viewed_memos = $viewed_book->memo;

        $genre_name = $viewed_book->genre->genre_name;
        return view('group-user-memo.view-status', compact('viewed_book', 'genre_name', 'group_user', 'viewed_memos', 'book_id'));
    }

    public function view(Request $request){
        if($request->group_id){
            $viewed_memo = Book::find($request->id)->memo->where('group_id', null)->first();
            $memo = Book::find($request->id)->memo->first();

            if($viewed_memo){
                $viewed_memo->group_id = $request->group_id;
                $viewed_memo->save();
            }elseif(!$viewed_memo){
                $viewed_memo = $memo->replicate();
                $viewed_memo->group_id = $request->group_id;
                $viewed_memo->save();
            }

        }elseif($request->non_group_id){
            $viewed_memo = Book::find($request->id)->memo->where('group_id', $request->non_group_id)->first();
            $viewed_memo->group_id = null;
            $viewed_memo->save();
        }

        return redirect()->route('book.index');
    }
}
