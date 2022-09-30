<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $selectedBook = Book::where('user_id', Auth::id())->oldest('created_at')->first();

        if(!Genre::where('user_id', Auth::id())->first()){
            $genre = new Genre;
            $genre->user_id = Auth::id();
            $genre->save();
        }
        if(GroupUser::where('user_id', Auth::id())->where('participation_status', '招待中')->first()){
            $is_group_user = true;
            $group_user = GroupUser::all();
        }else{
            $is_group_user = false;
            $group_user=null;
        }

        if($selectedBook){
            $genre_name = $selectedBook->genre->genre_name;
            return view('book.index', compact('selectedBook', 'genre_name', 'is_group_user', 'group_user'));
        }else{
            return view('book.index', compact('selectedBook', 'is_group_user'));
        }

    }

    public function search(){
        return view('book.search');
    }

     public function manual(){
        return view('book.manual');
    }

    public function temporaryStore(Request $request){
        $temporary_store_book = new Book;
        $temporary_store_book->title      = $request->title;
        $temporary_store_book->title_kana = $request->title_kana;
        $temporary_store_book->author     = $request->author;
        $temporary_store_book->image_path = $request->img;
        $temporary_store_book->user_id    = Auth::id();
        $temporary_store_book->save();

        return redirect()->route('book.create');
    }

    public function create(){
        $temporary_store_book = Book::latest('created_at')->first();
        return view('book.create', compact("temporary_store_book"));
    }

    public function store(Request $request){
        if(parse_url(url()->previous())['path'] == "/book/create"){
            $temporary_store_book = Book::latest('created_at')->first();
            $temporary_store_book->title = $request->title;
            $temporary_store_book->title_kana = $request->title_kana;
            $temporary_store_book->author = $request->author;
            $temporary_store_book->genre_id = $request->genre_id;
            $temporary_store_book->state = $request->state;
            $temporary_store_book->save();
        }else{
            $store_book = new Book;
            $store_book->title      = $request->title;
            $store_book->title_kana = $request->title_kana;
            $store_book->author     = $request->author;
            $store_book->genre_id   = $request->genre_id;
            $store_book->state      = $request->state;
            $store_book->image_path = "https://placehold.jp/200x300.png";
            $store_book->user_id    = Auth::id();
            $store_book->save();
        }

        if(Book::where('state', null)){
            Book::where('state', null)->delete();
        };
        return redirect()->route('book.index');
    }

    public function show(Book $book){
        $genre_name = $book->genre->genre_name;
        return view('book.index',  ['selectedBook' => $book, 'genre_name'=>$genre_name]);
    }

    public function destroy(Book $book){
        $book->delete();

        return redirect()->route('book.index');
    }

    public function update(Book $book){
        $book->state = "読書中";
        $book->save();

        return redirect()->route('book.index');
    }

    public function updateGroupUser(Request $request){
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

    public function destroyGroupUser(Request $request){
        $memo_groups = User::find(Auth::id())->memogroup;
        foreach ($memo_groups as $memo_group){
            if($memo_group->pivot->participation_status == '招待中'){
                $group_user = GroupUser::where('user_id', Auth::id())->where('group_id', $memo_group->id)->first();
                $group_user->delete();

                return redirect()->route('book.index');
            }
        }
    }

}
