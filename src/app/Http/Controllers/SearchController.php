<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
        public function index(Request $request)
    {
        if(session('search_books')){
            session()->forget('search_books');
        }

        $search_title = $request->search_title;
        $is_search_result = true;

        if ($search_title) {
            $space_conversioned_search_title = mb_convert_kana($search_title, 's');
            $array_conversioned_search_title = preg_split('/[\s,]+/', $space_conversioned_search_title, -1, PREG_SPLIT_NO_EMPTY);

            foreach($array_conversioned_search_title as $value) {
                $search_books = Book::where('user_id', Auth::id())->where('title', 'like', '%'.$value.'%')->paginate(3);
                session()->put(['search_books' => $search_books]);
            }

            if($search_books->isEmpty()){
                $is_search_result = false;

                return view('search-book.index', compact('is_search_result'));
            }else{
                $is_search_result = true;

                return view('search-book.index', compact('is_search_result', 'search_books'));
            }

        }else{
            return view('search-book.index', compact('is_search_result'));
        }

    }

    public function show(Book $book){
        $genre_name = $book->genre->genre_name;

        $is_publish_memo = false;

        if($book && ($book->state === Book::STATE_READING) && $book->memo && $book->memo()->first()->group_id){
            $is_publish_memo = true;
        }

        return view('search-book.show',  ['selectedBook' => $book, 'genre_name'=>$genre_name, 'is_publish_memo'=>$is_publish_memo]);
    }
}
