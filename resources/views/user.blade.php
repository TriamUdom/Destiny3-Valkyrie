@extends('layouts.master')

@section('content')
    @if(empty($data))
        ไม่มีข้อมูล
    @else
        <div class="row">
            <div class="col-xs-6">
                <h4 style="margin-bottom:0;"><b>นายทดสอบ ระบบ</b></h4>
                <h6 style="margin-top:0;font-size:1.1em;margin-bottom:0;">Mr. System Test</h6>
                <hr style="margin-top:5px;margin-bottom:15px;">
                <div class="row">
                    <div class="col-xs-4">
                        <p><i class="fa fa-phone"></i> (088) 888-8888</p>
                    </div>
                    <div class="col-xs-8">
                        <p><i class="fa fa-envelope"></i> test@example.com</p>
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
                        <p>วัน/เดือน/ปีเกิด: <b>00 มกราคม 0000</b> </p>
                    </div>
                    <div class="info" id="info_cid" style="display:none;">
                        <p>เลขประจำตัวประชาชน: <b>1-1111-11111-11-9</b> </p>
                        <p>วัน/เดือน/ปีเกิด: <b>00 มกราคม 0000</b> </p>
                        <p>ที่อยู่ปัจจุบัน: <b>12/231 ต.วังใหม่ อ.ทดสอบ จ.กระบี่ 10000</b> </p>
                        <p>ที่อยู่ตามทะเบียนบ้าน: <b>12/231 ต.วังใหม่ อ.ทดสอบ จ.กระบี่ 10000</b> </p>
                    </div>
                    <div class="info" id="info_transcript" style="display:none;">
                        Transcript data goes here
                    </div>
                </div>


            </div>
            <div class="col-xs-6">
                <div class="documentContainer" align="center">
                    <div class="document" id="document_photo">
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'image') }}" class="img-responsive">
                    </div>
                    <div class="document" id="document_cid" style="display:none;">
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'citizen_card') }}" class="img-responsive">
                    </div>
                    <div class="document" id="document_transcript" style="display:none;">
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'transcript') }}" class="img-responsive">
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
            showDocument("photo");
        });
        $("#btnCID").click(function(e){
            showDocument("cid");
        });
        $("#btnTranscript").click(function(e){
            showDocument("transcript");
        });
        $("#btnStudentHR").click(function(e){
            showDocument("student_hr");
        });
        $("#btnGradeVerification").click(function(e){
            showDocument("grade_verification");
        });

        function showDocument(document_name){
            $(".document").hide();
            $("#document_" + document_name).show();
        }
    </script>
@endsection
