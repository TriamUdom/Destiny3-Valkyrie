<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;

class DocumentsController extends Controller{
    public function showIndexPage(){
        $db = Document::where('status', '0')->get();
        return view('index')->with('data', $db);
    }

    public function displayDocument(Request $request, $citizen_id){

    }
}
