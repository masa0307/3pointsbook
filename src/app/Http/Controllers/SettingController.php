<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
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

    public function update(SettingRequest $request, $id){
        $user = User::find($id);

        if(strpos(url()->full(), 'user-name')){
            $user->name = $request->name;
            $user->save();
            $user_name = $user->name;

            return view('setting.user-name-edit', compact('user_name'));
        }elseif(strpos(url()->full(), 'email')){
            $user->email = $request->email;
            $user->save();
            $email = $user->email;

            return view('setting.email-edit', compact('email'));
        }elseif(strpos(url()->full(), 'password')){
            $user->password = Hash::make($request->update_password);
            $user->save();

            return view('setting.password-edit');
        }elseif(strpos(url()->full(), 'sort')){
            $user->sort_name = $request->sort_name;
            $user->save();
            $sort_name = $user->sort_name;

            return view('setting.book-sort-edit', compact('sort_name'));
        }
    }

    public function store(SettingRequest $request, $id){
        $genre = new Genre;
        $genre->genre_name = $request->genre_name;
        $genre->user_id = Auth::id();
        $genre->save();
        $genres =  User::find($id)->genre;

        return view('setting.genre-name-edit', compact('genres'));
    }
}
