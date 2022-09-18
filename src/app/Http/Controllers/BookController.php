<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $selectedBook = Book::oldest('created_at')->first();

        if(!Genre::where('user_id', Auth::id())->first()){
            $genre = new Genre;
            $genre->user_id = Auth::id();
            $genre->save();
        }

        if($selectedBook){
            $genre_name = $selectedBook->genre->genre_name;
            return view('book.index', compact('selectedBook', 'genre_name'));
        }else{
            return view('book.index', compact('selectedBook'));
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
        $temporary_store_book->title = $request->title;
        $temporary_store_book->title_kana = $request->title_kana;
        $temporary_store_book->author = $request->author;
        $temporary_store_book->image_path = $request->img;
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
            $store_book->title = $request->title;
            $store_book->title_kana = $request->title_kana;
            $store_book->author = $request->author;
            $store_book->genre_id = $request->genre_id;
            $store_book->state = $request->state;
            $store_book->image_path = "https://placehold.jp/200x300.png";
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

    public function destroy($id){
        $book = Book::find($id);
        $book->delete();

        return redirect()->route('book.index');
    }
}
