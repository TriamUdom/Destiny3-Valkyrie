<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use RESTResponse;
use DB;
use Log;
use Exception;

class ApplicantController extends Controller{
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
                'image' => 0,
                'citizen_card' => 0,
                'transcript' => 0,
                'student_hr' => 0,
                'father_hr' => 0,
                'mother_hr' => 0,
            ),
            'check_status' => 0,
            'submitted' => time(),
        ]);

        return RESTResponse::ok();
    }

    public function showIndexPage(){
        $db = Applicant::where('check_status', 0)->get();
        return view('index')->with('data', $db);
    }

    public function displayDocument(Request $request, $object_id){
        $data = Applicant::where('_id', $object_id)->first();
        return view('user')->with('data', $data);
    }

    public function updateDocumentStatus(Requets $requets, $object_id, $document){
        $accepted_document = ['image', 'citizen_card', 'transcript', 'student_hr', 'father_hr', 'mother_hr'];
        if(!in_array($document, $accepted_document)){
            abort(400);
        }

        $accepted_action = ['accepted' => 1, 'denial' => -1];
        if(!in_array($request->input('action'), $accepted_action)){
            abort(400);
        }

        $update = Applicant::where('_id', $object_id)->update([
            'documents.'.$document => $accepted_action[$request->input('action')],
        ]);

        if($update === 1){
            return RESTResponse::ok();
        }else if($update === 0){
            return RESTResponse::notFound();
        }else{
            throw new Exception('More than one row was effected');
        }
    }
}
