<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use RESTResponse;
use DB;
use Log;
use Exception;
use Config;
use Session;

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
            ),
            'submitted' => time(),
        ]);

        $all = Applicant::where('citizen_id', $citizen_id)
                        ->where('check_status', 0)
                        ->orderBy('submitted', 'desc')
                        ->get();

        if(count($all) !== 1){
            throw new Exception('More than one pending row');
        }else{
            $id = $all[0]['_id'];
        }

        return RESTResponse::ok($id);
    }

    public function showIndexPage(){
        $db = Applicant::where('check_status', 0)->get();
        return view('index')->with('data', $db);
    }

    public function displayDocument(Request $request, $object_id){
        $data = Applicant::where('_id', $object_id)->first();
        return view('user')->with('data', $data);
    }

    public function updateDocumentStatus(Request $request, $object_id, $document){
        $accepted_document = ['image', 'citizen_card', 'transcript', 'student_hr', 'gradecert'];
        if(!in_array($document, $accepted_document)){
            abort(400);
        }

        $accepted_action = ['accepted' => 1, 'denial' => -1];
        if(!in_array($request->input('action'), $accepted_action)){
            abort(400);
        }

        $update = Applicant::where('_id', $object_id)->update([
            'evaluation.'.Session::get('admin_id').'.'.$document.'.status' => $accepted_action[$request->input('action')],
            'evaluation.'.Session::get('admin_id').'.'.$document.'.comment' => $accepted_action[$request->input('comment')],
        ]);

        if($update === 1){
            return RESTResponse::ok();
        }else if($update === 0){
            return RESTResponse::notFound();
        }else{
            throw new Exception('More than one row was effected');
        }
    }

    public function updateAcceptanceStatus(Request $request, $object_id){
        if(!in_array($request->input('status'), [1, -1])){
            abort(400);
        }

        $all_docs = Applicant::where('_id', $object_id)->pluck('documents')[0];

        if($all_docs['image'] == 0 || $all_docs['citizen_card'] == 0 ||
            $all_docs['transcript'] == 0 || $all_docs['student_hr'] == 0 ||
            $all_docs['father_hr'] == 0 || $all_docs['mother_hr'] == 0){

            return RESTResponse::badRequest('Not all document have been inspected');
        }

        if($all_docs['image'] == 1 && $all_docs['citizen_card'] == 1 &&
            $all_docs['transcript'] == 1 && $all_docs['student_hr'] == 1 &&
            $all_docs['father_hr'] == 1 && $all_docs['mother_hr'] == 1){

            $status = 1;
        }else{
            $status = -1;
        }

        Applicant::where('_id', $object_id)->update([
            'check_status' => $status
        ]);

        if($this->notifyUI($status, $object_id)){
            return redirect('/')->with('message', 'UI notified');
        }else{
            return RESTResponse::serverError('Cannot send data to UI');
        }
    }

    private function notifyUI($status, $object_id){
        $db = Applicant::where('_id', $object_id)->first();

        $base_path = Config::get('api.base_path');
        $sendto = "$base_path/api/v1/applicant/".$db['citizen_id']."/status";

        // Init cURL and set stuff:
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sendto);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        // VERY VERY IMPORTANT: the API key header.
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "api-key: 1234" // TODO : insert real api key
        ));

        $payload = [
            'status' => $status,
            'object_id' => $object_id,
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); // POST data field(s)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // run the cURL query
        $result = curl_exec($ch);
        $returnHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($returnHttpCode == 200){
            return true;
        }else{
            return false;
        }
    }
}
