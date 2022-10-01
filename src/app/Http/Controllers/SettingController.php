<?php

namespace App\Http\Controllers;

use App\Http\ViewComposers\BookComposer;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function edit($id){
        if(strpos(url()->full(), 'user-name')){
            $user_name = User::find($id)->name;
            return view('setting.user-name-edit', compact('user_name'));
        }elseif(strpos(url()->full(), 'email')){
            $email = User::find($id)->email;
            return view('setting.email-edit', compact('email'));
        }elseif(strpos(url()->full(), 'password')){
            return view('setting.password-edit');
        }elseif(strpos(url()->full(), 'sort')){
            $sort_name = User::find($id)->sort_name;
            return view('setting.book-sort-edit', compact('sort_name'));
        }elseif(strpos(url()->full(), 'genre')){
            $genres =  User::find($id)->genre;
            return view('setting.genre-name-edit', compact('genres'));
        }
    }

    public function update(Request $request, $id){
        $user = User::find($id);

        if(strpos(url()->full(), 'user-name')){
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:users'],
            ]);

            $user->name = $request->name;
            $user->save();
        }elseif(strpos(url()->full(), 'email')){
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

            $user->email = $request->email;
            $user->save();
        }elseif(strpos(url()->full(), 'password')){
            $user->password = Hash::make($request->update_password);
            $user->save();
        }elseif(strpos(url()->full(), 'sort')){
            $user->sort_name = $request->sort_name;
            $user->save();
        }

        return redirect()->route('book.index');
    }

    public function store(Request $request){
        $genre = new Genre;
        $genre->genre_name = $request->genre_name;
        $genre->user_id = Auth::id();
        $genre->save();

        return redirect()->route('book.index');
    }
}
