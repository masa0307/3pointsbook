<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
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
        $memo_groups  = User::find(Auth::id())->memogroup()->get();

        if(!(Genre::where('user_id', Auth::id())->first())){
            $genre          = new Genre;
            $genre->user_id = Auth::id();
            $genre->save();
        }

        if($selectedBook){
            $genre_name = $selectedBook->genre->genre_name;
        }else{
            $genre_name = null;
        }

        if(GroupUser::where('user_id', Auth::id())->where('participation_status', '招待中')->first()){
            $is_invited_group_users = true;
            $invited_group_users    = GroupUser::where('user_id', Auth::id())->where('participation_status', '招待中')->get();

            foreach ($invited_group_users as $count => $invited_group_user){
                $invitee = User::find($memo_groups[0]->pivot->where('is_owner', true)->where('group_id', $invited_group_user->group_id)->first()->user_id)->name;
                $invtee_group_name = $memo_groups->where('id', $invited_group_user->group_id)->first()->group_name;
            }

            return view('book.index', compact('selectedBook', 'genre_name', 'is_invited_group_users', 'invited_group_users', 'invitee', 'invtee_group_name'));
        }else{
            $is_invited_group_users = false;

            return view('book.index', compact('selectedBook', 'genre_name', 'is_invited_group_users'));
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

    public function store(BookRequest $request){
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
        $is_invited_group_users = false;

        if($book->state == '読書中' && $book->memo()->first()->group_id){
            $is_publish_memo = true;
        }else{
            $is_publish_memo = false;
        }

        return view('book.show',  ['selectedBook' => $book, 'genre_name'=>$genre_name, 'is_invited_group_users'=>$is_invited_group_users, 'is_publish_memo'=>$is_publish_memo]);
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
}
