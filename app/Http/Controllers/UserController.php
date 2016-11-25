<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use RESTResponse;
use DB;
use Log;

class UserController extends Controller{
    public function handleIncomingRequest(Request $request, $citizen_id){
        /*$this->validate($request, [
            'fname' => 'required',
            'lanme' => 'required',
            ''
        ]);*/

        Applicant::create([
            'citizen_id' => $citizen_id,
            'title' => $request->input('title'),
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'title_en' => $request->input('title_en'),
            'fname_en' => $request->input('fname_en'),
            'lname_en' => $request->input('lname_en'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'birthdate' => $request->input('birthdate'),
            'staying_with_parent' => $request->input('staying_with_parent'),
            'father' => $request->input('father'),
            'mother' => $request->input('mother'),
            'guardian' => $request->input('guardian'),
            'school' => $request->input('school'),
            'graduation_year' => $request->input('graduation_year'),
            'gpa' => $request->input('gpa'),
            'school_move_in' => $request->input('school_move_in'),
            'school_province' => $request->input('school_province'),
            'address' => $request->input('address'),
            'application_type' => $request->input('application_type'),
            'quota_type' => $request->input('quota_type'),
            'plan' => $request->input('plan'),
            'majors' => $request->input('majors'),
            'quota_grade' => $request->input('quota_grade'),
            'documents' => array(
                'timestamp' => $request->input('documents.timestamp'),
                'access_token' => $request->input('documents.access_token'),
            ),
            'check_status' => 0,
        ]);

        return RESTResponse::ok();
    }

    public function showIndexPage(){
        $db = Applicant::where('check_status', 0)->get();
        return view('index')->with('data', $db);
    }

    public function displayDocument(Request $request, $object_id){
        $data = Applicant::where('_id', $object_id)->first()[0];
        return view('user')->with('data', $data);
    }
}
