<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller{
    public function showIndexPage(){
        return view('master');
    }

    public function showLoginPage(){
        return view('login');
    }

    public static function adminLoggedIn(): bool {
        return (session('applicant_logged_in') == 1);
    }
}
