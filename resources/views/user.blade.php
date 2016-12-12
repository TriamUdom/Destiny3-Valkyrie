@extends('layouts.master')

@section('content')
    @if(empty($data))
        ไม่มีข้อมูล
    @else
        <div class="row">
            <div class="col-xs-6">
                <h4 style="margin-bottom:0;"><b>{{$data->title}}{{$data->fname}} {{$data->lname}}</b></h4>
                <h6 style="margin-top:0;font-size:1.1em;margin-bottom:0;">{{$data->title_en}} {{$data->fname_en}} {{$data->lname_en}}</h6>
                <hr style="margin-top:5px;margin-bottom:15px;">
                <div class="row">
                    <div class="col-xs-4">
                        <p><i class="fa fa-phone"></i> {{$data->phone}} {{-- TODO: FORMATTING --}}</p>
                    </div>
                    <div class="col-xs-8">
                        <p><i class="fa fa-envelope"></i> {{$data->email}}</p>
                    </div>
                </div>
                <hr style="margin-top:0px;margin-bottom:15px;">
                <div class="row">
                    <div class="col-xs-4">
                        <button id="btnGenInfo" class="btn btn-sm btn-block btn-primary">รูปถ่าย</button>
                    </div>
                    <div class="col-xs-4">
                        <button id="btnCID" class="btn btn-sm btn-block btn-primary">บัตรประจำตัวประชาชน</button>
                    </div>
                    <div class="col-xs-4">
                        <button id="btnTranscript" class="btn btn-sm btn-block btn-primary">ผลการเรียน</button>
                    </div>
                </div>
                <div style="height:10px;">&nbsp;</div>
                <div class="row">
                    <div class="col-xs-4">
                        <button id="btnStudentHR" class="btn btn-sm btn-block btn-primary">ทะเบียนบ้านนักเรียน</button>
                    </div>
                    <div class="col-xs-4">
                        <button id="btnGradeVerification" class="btn btn-sm btn-block btn-primary">ใบรับรองผลการเรียน</button>
                    </div>
                </div>
                <div style="height:10px;">&nbsp;</div>
                <hr style="margin-top:0px;margin-bottom:15px;">

                <div class="infoContainer">
                    <div class="info" id="info_photo">
                        <p>วัน/เดือน/ปีเกิด: <b>{{$data->birthdate["day"]}} / {{$data->birthdate["month"]}} / {{$data->birthdate["year"]}}</b> </p>
                        <p>จบการศึกษาจากโรงเรียน: <b>{{$data->school}}</b> </p>
                    </div>
                    <div class="info" id="info_cid" style="display:none;">
                        <p>เลขประจำตัวประชาชน: <b>{{$data->citizen_id}}</b> </p>
                        <p>วัน/เดือน/ปีเกิด: <b>{{$data->birthdate["day"]}} / {{$data->birthdate["month"]}} / {{$data->birthdate["year"]}}</b> </p>
                        <p>ที่อยู่ปัจจุบัน: <b>{{$data->address["home"]["home_address"]}} หมู่ {{$data->address["home"]["home_moo"]}} ซอย {{$data->address["home"]["home_soi"]}} ถนน{{$data->address["home"]["home_road"]}} ตำบล{{$data->address["home"]["home_subdistrict"]}} อำเภอ{{$data->address["home"]["home_district"]}} จังหวัด{{$data->address["home"]["home_province"]}} {{$data->address["home"]["home_postcode"]}}</b> </p>
                        <p>ที่อยู่ตามทะเบียนบ้าน: <b>{{$data->address["current"]["current_address"]}} หมู่ {{$data->address["current"]["current_moo"]}} ซอย {{$data->address["current"]["current_soi"]}} ถนน{{$data->address["current"]["current_road"]}} ตำบล{{$data->address["current"]["current_subdistrict"]}} อำเภอ{{$data->address["current"]["current_district"]}} จังหวัด{{$data->address["current"]["current_province"]}} {{$data->address["current"]["current_postcode"]}}</b> </p>
                    </div>
                    <div class="info" id="info_transcript" style="display:none;">
                        Transcript data goes here
                    </div>
                    <div class="info" id="info_student_hr" style="display:none;">
                        <p>เลขประจำตัวประชาชน: <b>{{$data->citizen_id}}</b> </p>
                        <p>วัน/เดือน/ปีเกิด: <b>{{$data->birthdate["day"]}} / {{$data->birthdate["month"]}} / {{$data->birthdate["year"]}}</b> </p>
                        <p>ที่อยู่ปัจจุบัน: <b>{{$data->address["home"]["home_address"]}} หมู่ {{$data->address["home"]["home_moo"]}} ซอย {{$data->address["home"]["home_soi"]}} ถนน{{$data->address["home"]["home_road"]}} ตำบล{{$data->address["home"]["home_subdistrict"]}} อำเภอ{{$data->address["home"]["home_district"]}} จังหวัด{{$data->address["home"]["home_province"]}} {{$data->address["home"]["home_postcode"]}}</b> </p>
                        <p>ที่อยู่ตามทะเบียนบ้าน: <b>{{$data->address["current"]["current_address"]}} หมู่ {{$data->address["current"]["current_moo"]}} ซอย {{$data->address["current"]["current_soi"]}} ถนน{{$data->address["current"]["current_road"]}} ตำบล{{$data->address["current"]["current_subdistrict"]}} อำเภอ{{$data->address["current"]["current_district"]}} จังหวัด{{$data->address["current"]["current_province"]}} {{$data->address["current"]["current_postcode"]}}</b> </p>
                    </div>
                </div>


            </div>
            <div class="col-xs-6">
                <div class="documentContainer" align="center">
                    <div class="document" id="document_photo">
                        <small class="text-muted">รูปถ่ายนักเรียน</small>
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'image') }}" class="img-responsive zoomableImage">
                    </div>
                    <div class="document" id="document_cid" style="display:none;">
                        <small class="text-muted">บัตรประจำตัวประชาชน</small>
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'citizen_card') }}" class="img-responsive zoomableImage">
                    </div>
                    <div class="document" id="document_transcript" style="display:none;">
                        <small class="text-muted">ใบแสดงผลการเรียน</small>
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'transcript') }}" class="img-responsive zoomableImage">
                    </div>
                    <div class="document" id="document_student_hr" style="display:none;">
                        <small class="text-muted">ทะเบียนบ้านนักเรียน</small>
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'student_hr') }}" class="img-responsive zoomableImage">
                    </div>
                    <div class="document" id="document_grade_verification" style="display:none;">
                        <small class="text-muted">ใบรับรองผลการเรียน</small>
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'gradecert') }}" class="img-responsive zoomableImage">
                    </div>
                    <small>(คลิกที่รูปเพื่อดูรูปขนาดใหญ่ขึ้น)</small>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-6">
                        <button id="btnAcceptDoc" class="btn btn-sm btn-block btn-success">ยืนยันเอกสารถูกต้อง</button>
                    </div>
                    <div class="col-xs-6">
                        <button id="btnRejectDoc" class="btn btn-sm btn-block btn-danger">เอกสารไม่ถูกต้อง</button>
                    </div>
                </div>
            </div>
        </div>



        <form action="/applicants/status/{{ $data['_id'] }}" method="post">
            <input type="hidden" value="1" name="status">
            <input type="submit" value="accept">
            {{ csrf_field() }}
        </form>
    @endif
@endsection

@section('additional_scripts')
    <script>
        var currentDoc = "photo";

        $("#btnGenInfo").click(function(e){
            e.preventDefault();
            showDocument("photo");
        });
        $("#btnCID").click(function(e){
            e.preventDefault();
            showDocument("cid");
        });
        $("#btnTranscript").click(function(e){
            e.preventDefault();
            showDocument("transcript");
        });
        $("#btnStudentHR").click(function(e){
            e.preventDefault();
            showDocument("student_hr");
        });
        $("#btnGradeVerification").click(function(e){
            e.preventDefault();
            showDocument("grade_verification");
        });

        function showDocument(document_name){
            console.log("SHOWING DOC: " + document_name);
            currentDoc = document_name;
            $(".info").hide();
            $(".document").hide();
            $("#info_" + document_name).show();
            $("#document_" + document_name).show();
        }

        $(".zoomableImage").click(function(){
            bootbox.alert({
                message: "<img src='" + $(this).attr("src") + "' style='width:100%;' />",
                size: 'large'
            });
        });
    </script>
@endsection
