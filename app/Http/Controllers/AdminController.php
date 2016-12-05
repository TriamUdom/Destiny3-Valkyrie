<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin as Admin;
use Hash;
use Session;
use App\Supervisor as Supervisor;

class AdminController extends Controller{
    public function showIndexPage(){
        return view('index');
    }

    public function showSupervisorLoginPage(){
        return view('supervisor_login');
    }

    public function supervisorLogin(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $db = Supervisor::where('username', $request->input('username'))->first();

        if(count($db) === 1){
            if(Hash::check($request->input('password'), $db->password)){
                Session::put('supervisor_logged_in', 1);
                Session::put('supervisor_name', $db->name);

                return redirect('/login');
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

    public static function supervisorLoggedIn(): bool {
        return (session('supervisor_logged_in') == 1);
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
                Session::put('admin_name', $db->name);
                Session::put('admin_id', $db->_id);

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
