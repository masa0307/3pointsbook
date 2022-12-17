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

        $group_users      = GroupUser::where('group_id', session('group')->id)->get();
        $group_user_name  = $request->name;
        $group_name       = MemoGroup::where('id', session('group')->id)->first()->group_name;

        if ($group_user_name) {
            $space_conversioned_group_user_name = mb_convert_kana($group_user_name, 's');
            $search_user                        = User::where('name', $space_conversioned_group_user_name)->first();
            session()->put(['search_user' => $search_user]);
            session()->put(['group_name' => $group_name]);
        }

        return view('group-user.search', compact('group_users'));
    }

    public function store(GroupUserRequest $request){
        $group_user                       = new GroupUser;
        $group_user->group_id             = session('group')->id;
        $group_user->user_id              = $request->user_id;
        $group_user->is_owner             = false;
        $group_user->participation_status = "招待中";
        $group_user->save();

        return redirect()->route('group-user.search');
    }

    //招待されたユーザーがグループへの参加を選択したときの処理
    public function accept(Request $request){
        $invited_group_users = GroupUser::where('user_id', Auth::id())->where('participation_status', '招待中')->get();

        foreach ($invited_group_users as $count => $invited_group_user){
            if($count === 0){
                $invited_group_user->participation_status = $request->participation_status;
                $invited_group_user->save();
            }

            return redirect()->route('book.index');
        }
    }

    //招待されたユーザーがグループへの非参加を選択したときの処理
    public function reject(){
        $invited_group_users = GroupUser::where('user_id', Auth::id())->where('participation_status', '招待中')->get();

        foreach ($invited_group_users as $invited_group_user){
            $invited_group_user->delete();
            return redirect()->route('book.index');
        }
    }

    public function edit($id){
        $group_users = GroupUser::with('user')->where('group_id', $id)->get();
        $group_name  = MemoGroup::find($id)->group_name;

        session()->put(['group'=>MemoGroup::find($id) ]);
        session()->put(['group_name' => $group_name]);

        $current_url = url()->current();

        if(strstr($current_url, "add")){
            return view('group-user.add', compact('group_users'));
        }

        return view('group-user.edit', compact('group_users'));
    }

    public function destroy($group_id, $user_id){
        $group_user    = GroupUser::where('group_id', $group_id)->where('user_id', $user_id)->first();
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
        $group_id_parameter = substr(rtrim($_SERVER["REQUEST_URI"], '/'), strrpos(rtrim($_SERVER["REQUEST_URI"], '/'), '/') + 1);

        if($selectedBook){
            $genre_name = $selectedBook->genre->genre_name;
            return view('group-user-memo.index', compact('selectedBook', 'genre_name', 'group_name', 'users', 'group_id_parameter'));
        }else{
            return view('group-user-memo.index', compact('selectedBook', 'users', 'group_id_parameter'));
        }
    }

    public function show($book_id, $group_id){
        $store_memo = Memo::where('book_id',$book_id)->first();
        $select_book = Book::where('id', $book_id)->first();
        $group_name = MemoGroup::find($group_id)->group_name;
        $group_id_parameter = substr(rtrim($_SERVER["REQUEST_URI"], '/'), strrpos(rtrim($_SERVER["REQUEST_URI"], '/'), '/') + 1);

        if($store_memo ){
            $is_store_memo = true;
        }else{
            $is_store_memo = false;
        }

        return view('group-user-memo.show', compact('store_memo', 'is_store_memo', 'select_book', 'book_id', 'group_id', 'group_name', 'group_id_parameter'));
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
        $book = Book::find($request->id);
        if($request->group_id){
            $published_memo = $book->memo->where('group_id', null)->first();
            $memo = $book->memo->first();

            if($published_memo){
                $published_memo->group_id = $request->group_id;
                $published_memo->save();
            }elseif(!$published_memo){
                $published_memo = $memo->replicate();
                $published_memo->group_id = $request->group_id;
                $published_memo->save();
            }

        }elseif($request->non_group_id){
            $published_memo = $book->memo->where('group_id', $request->non_group_id)->first();
            $published_memo->group_id = null;
            $published_memo->save();
        }

        return redirect()->route('book.show', [$book, str_replace('?', '', mb_strstr(url()->full(), '?'))]);
    }
}
