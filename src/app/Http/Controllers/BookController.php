<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $selectedBook = Book::oldest('created_at')->first();
        if($selectedBook){
            $genre_name = $selectedBook->genre->genre_name;
            return view('index', compact('selectedBook', 'genre_name'));
        }else{
            return view('index', compact('selectedBook'));
        }


    }

    public function search(){
        return view('search');
    }

     public function manual(){
        return view('manual');
    }

    public function temporaryStore(Request $request){
        $img = $request->img;
        $title = $request->title;
        $author = $request->author;

        $temporary_store_book = new Book;
        $temporary_store_book->title = $title;
        $temporary_store_book->author = $author;
        $temporary_store_book->image_path = $img;
        $temporary_store_book->save();

        return redirect()->route('book.create');
    }

    public function create(){
        $temporary_store_book = Book::latest('created_at')->first();
        return view('create', compact("temporary_store_book"));
    }

    public function store(Request $request){
        if(parse_url(url()->previous())['path'] == "/book/create"){
            $temporary_store_book = Book::latest('created_at')->first();
            $temporary_store_book->title = $request->title;
            $temporary_store_book->author = $request->author;
            $temporary_store_book->genre_id = $request->genre_id;
            $temporary_store_book->state = $request->state;
            $temporary_store_book->save();
        }else{
            $store_book = new Book;
            $store_book->title = $request->title;
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
        return view('index',  ['selectedBook' => $book, 'genre_name'=>$genre_name]);
    }

    public function destroy($id){
        $book = Book::find($id);
        $book->delete();

        return redirect()->route('book.index');
    }
}
