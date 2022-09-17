<?php

namespace App\Http\Controllers;

use App\Http\ViewComposers\BookComposer;
use App\Models\User;
use Illuminate\Http\Request;
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
        }
    }

    public function update(Request $request, $id){
        $user = User::find($id);

        if(strpos(url()->full(), 'user-name')){
            $user->name = $request->user_name;
            $user->save();
        }elseif(strpos(url()->full(), 'email')){
            $user->email = $request->email;
            $user->save();
        }elseif(strpos(url()->full(), 'password')){
            $user->password = Hash::make($request->update_password);
            $user->save();
        }

        return redirect()->route('book.index');
    }
}
