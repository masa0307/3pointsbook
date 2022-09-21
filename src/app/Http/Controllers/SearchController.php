<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
        public function index(Request $request)
    {
        if(session('search_book')){
            session()->forget('search_book');
        }

        $search_title = $request->search_title;

        if ($search_title) {
            $space_conversioned_search_title = mb_convert_kana($search_title, 's');
            $array_conversioned_search_title = preg_split('/[\s,]+/', $space_conversioned_search_title, -1, PREG_SPLIT_NO_EMPTY);

            foreach($array_conversioned_search_title as $value) {
                $search_book = Book::where('user_id', Auth::id())->where('title', 'like', '%'.$value.'%')->get();
                session()->put(['search_book' => $search_book]);
            }
        }

        return view('search-book.index');
    }
}
