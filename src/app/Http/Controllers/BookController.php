<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('index', compact("books"));
    }

    public function search(){
        $books= Book::all();
        return view('search', compact("books"));
    }

     public function manual(){
        $books= Book::all();
        $genres = Genre::all();
        return view('manual', compact("books", "genres"));
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
        $books = Book::all();
        $genres = Genre::all();
        $temporary_store_book = Book::latest('created_at')->first();
        return view('create', compact("temporary_store_book", "books", "genres"));
    }

    public function store(Request $request){
        $books= Book::all();
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
            $store_book->save();
        }

        if(Book::where('state', null)){
            Book::where('state', null)->delete();
        };
        return redirect()->route('book.index')->with(compact('books'));
    }
}
