<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin as Admin;
use Hash;
use Session;

class AdminController extends Controller{
    public function showIndexPage(){
        return view('master');
    }

    public function showLoginPage(){
        return view('login');
    }

    public function login(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $db = Admin::where('username', $request->input('username'))->first();

        if(count($db) === 1){
            if(Hash::check($request->input('password'), $db->password)){
                Session::put('admin_logged_in', 1);

                return redirect('/');
            }else{
                //TODO handle error properly
                dd('incorrect password');
                return false;
            }
        }else{
            //TODO handle error properly
            dd('user not found');
            return false;
        }
    }

    public static function adminLoggedIn(): bool {
        return (session('admin_logged_in') == 1);
    }

    public function logout(){
        Session::flush();
        Session::regenerate();

        return redirect('/login');
    }
}
