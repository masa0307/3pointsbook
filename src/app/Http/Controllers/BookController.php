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
        $selectedBook = Book::where('user_id', Auth::id())->oldest('created_at')->where('state', Book::STATE_READING)->first();

        if(!$selectedBook){
            $selectedBook = Book::where('user_id', Auth::id())->oldest('created_at')->first();
        }

        $memo_groups  = User::find(Auth::id())->memogroup;

        $is_publish_memo = false;

        if($selectedBook && ($selectedBook->state === Book::STATE_READING) && $selectedBook->memo){
            foreach($selectedBook->memo as $memo){
                if(isset($memo->group_id)){
                    $is_publish_memo = true;
                    break;
                }
            }
        }

        if(!(Genre::where('user_id', Auth::id())->first())){
            $genre          = new Genre;
            $genre->user_id = Auth::id();
            $genre->save();
        }

        $genre_name = null;

        if($selectedBook){
            $genre_name = $selectedBook->genre->genre_name;
        }

        $is_invited_group_user = false;
        $invited_group_users   = GroupUser::where('user_id', Auth::id())->where('participation_status', '招待中')->get();

        if($invited_group_users->isEmpty()){
            return view('book.index', compact('selectedBook', 'genre_name', 'is_invited_group_user', 'is_publish_memo'));
        }

        $is_invited_group_user = true;

        foreach($invited_group_users as $invited_group_user){
            $invitee_user_id   = GroupUser::where('is_owner', true)->where('group_id', $invited_group_user->group_id)->first()->user_id;
            $invitee_user_name = User::find($invitee_user_id)->name;
            $invtee_group_name = $memo_groups->where('id', $invited_group_user->group_id)->first()->group_name;

            return view('book.index', compact('selectedBook', 'genre_name', 'is_invited_group_user', 'invitee_user_name', 'invtee_group_name', 'is_publish_memo'));
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
        if(strpos(url()->previous(), "/book/create")){
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
        $is_publish_memo        = false;

        if($book && ($book->state === Book::STATE_READING) && $book->memo){
            foreach($book->memo as $memo){
                if(isset($memo->group_id)){
                    $is_publish_memo = true;
                    break;
                }
            }
        }

        return view('book.show',  ['selectedBook' => $book, 'genre_name'=>$genre_name, 'is_invited_group_users'=>$is_invited_group_users, 'is_publish_memo'=>$is_publish_memo]);
    }

    public function destroy(Book $book){
        $book->delete();

        return redirect()->route('book.index');
    }

    public function update(Book $book){
        $book->state = Book::STATE_READING;
        $book->save();

        return redirect()->route('book.index');
    }
}
