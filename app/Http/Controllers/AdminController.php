<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller{
    public static function adminLoggedIn(): bool {
        return (session('applicant_logged_in') == 1);
    }
}
