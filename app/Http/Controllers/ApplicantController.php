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

        $count = Applicant::where('citizen_id', $citizen_id)
                        ->where('ui_notified', 0)
                        ->orderBy('submitted', 'desc')
                        ->count();

        if($count !== 0){
            throw new Exception('Pending document exists');
        }

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
            'school_province' => $request->input('school_province'),
            'school2' => $request->input('school2'),
            'school2_province' => $request->input('school2_province'),
            'gpa' => $request->input('gpa'),
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
            'ui_notified' => 0,
        ]);

        $id = Applicant::where('citizen_id', $citizen_id)
                        ->where('ui_notified', 0)
                        ->pluck('_id')[0];

        return RESTResponse::ok($id);
    }

    public function showIndexPage(){
        $db = Applicant::where('ui_notified', 0)->get();
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

        $all_docs = Applicant::where('_id', $object_id)->pluck('evaluation.'.Session::get('admin_id'))[0];

        if($all_docs['image']['status'] == 0 || $all_docs['citizen_card']['status'] == 0 ||
            $all_docs['transcript']['status'] == 0 || $all_docs['student_hr']['status'] == 0 ||
            $all_docs['gradecert']['status'] == 0){

            return RESTResponse::badRequest('Not all document have been inspected');
        }

        if($all_docs['image']['status'] == -1 || $all_docs['citizen_card']['status'] == -1 ||
            $all_docs['transcript']['status'] == -1 || $all_docs['student_hr']['status'] == -1 ||
            $all_docs['gradecert']['status'] == -1){

            if($this->notifyUIOnFailure($status, $object_id)){
                return redirect('/')->with('message', 'UI notified');
            }else{
                return RESTResponse::serverError('Cannot send data to UI');
            }
        }
    }

    private function notifyUIOnFailure($status, $object_id){
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

        $comments = [];

        foreach($db['evaluation'] as $admin_id){
            foreach($admin_id as $document){
                if($document['status'] == -1 && !empty($document['comment'])){
                    $comments[] = $document['comment'];
                }
            }
        }

        if(empty($comments)){
            throw new Exception('No comment found');
        }

        $payload = [
            'object_id' => $object_id,
            'comments' => $comments,
            'status' => -1,
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); // POST data field(s)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // run the cURL query
        $result = curl_exec($ch);
        $returnHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($returnHttpCode == 200){
            Applicant::where('_id', $object_id)->update([
                'ui_notified' => 1,
            ]);

            return true;
        }else{
            return false;
        }
    }

    public static function notifyUIOnsuccess($id){
        $citizen_id = Applicant::where('_id', $id)->value('citizen_id');

        $sendto = Config::get('api.base_path').'/api/v1/applicant/'.$citizen_id.'/status';

        // Init cURL and set stuff:
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sendto);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

        // VERY VERY IMPORTANT: the API key header.
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "api-key: 1234" // TODO : insert real api key
        ));

        $payload = [
            'object_id' => $object_id,
            'status' => 1,
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload)); // POST data field(s)
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // run the cURL query
        $result = curl_exec($ch);
        $returnHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $returnHttpCode;
    }

    public static function getPassedApplicantID(){
        $all = Applicant::where('ui_notified', 0)->get();

        if(count($all) == 0){
            return 'Nothing to report (Row count equal to 0)';
        }

        $passed_id = [];

        foreach($all as $object_id => $applicant){
            if(!isset($applicant['evaluation'])){
                continue;
            }

            foreach($applicant->evaluation as $eval_admin){
                foreach($eval_admin as $document){
                    if($document['status'] == 0 || $document['status'] == -1){
                        break 2;
                    }
                }
            }

            $passed_id[] = $object_id;
        }

        if(empty($passed_id)){
            return 'Nothing to report (No one pass)';
        }

        return $passed_id;
    }

    public static function renderDocument($object_id, $document_name){
        $db = Applicant::where('_id', $object_id)->first();

        $sendto = Config::get('api.base_path').'/api/v1/documents/'.$db['citizen_id'].'/'.$document_name;
        $sendto .= '?timestamp='.$db['documents']['timestamp'].'&token='.$db['documents']['access_token'];

        // Init cURL and set stuff:
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sendto);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        // VERY VERY IMPORTANT: the API key header.
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "api-key: 1234" // TODO : insert real api key
        ));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // run the cURL query
        $result = curl_exec($ch);
        $returnHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $file = json_decode($result)->data->$document_name;

        $f = finfo_open();
        $mime_type = finfo_buffer($f, $file, FILEINFO_MIME_TYPE);
        finfo_close($f);

        return 'data:'.$mime_type.';base64,'.$file;
    }
}
