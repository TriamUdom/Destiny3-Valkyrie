@extends('layouts.master')

@section('content')
    @if(empty($data))
        ไม่มีข้อมูล
    @else
        <div class="row">
            <div class="col-xs-6">
                <div class="row">
                    <div class="col-xs-4">
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'image') }}" class="img-responsive zoomableImage">
                    </div>
                    <div class="col-xs-8">
                        <h4 style="margin-bottom:0;"><b>{{$data->title}}{{$data->fname}} {{$data->lname}}</b></h4>
                        <h6 style="margin-top:0;font-size:1.1em;margin-bottom:0;">{{$data->title_en}} {{$data->fname_en}} {{$data->lname_en}}</h6>
                        <hr style="margin-top:5px;margin-bottom:15px;">
                        <div class="row">
                            <p><i class="fa fa-phone"></i> {{$data->phone}} {{-- TODO: FORMATTING --}}</p>
                            <p><i class="fa fa-envelope"></i> {{$data->email}}</p>
                        </div>
                    </div>
                </div>

                <hr style="margin-top:0px;margin-bottom:15px;">
                <div class="row">
                    <div class="col-xs-4">
                        <button id="btn_image" class="btn btn-sm btn-block btn-primary">รูปถ่ายนักเรียน <i class="fa fa-check-circle" id="check_image" style="display:none;"></i> <i class="fa fa-times" id="error_image" style="display:none;"></i></button>
                    </div>
                    <div class="col-xs-4">
                        <button id="btn_citizen_card" class="btn btn-sm btn-block btn-primary">บัตรประจำตัวประชาชน <i class="fa fa-check-circle" id="check_citizen_card" style="display:none;"></i> <i class="fa fa-times" id="error_citizen_card" style="display:none;"></i></button>
                    </div>
                    <div class="col-xs-4">
                        <button id="btn_transcript" class="btn btn-sm btn-block btn-primary">ผลการเรียน <i class="fa fa-check-circle" id="check_transcript" style="display:none;"></i> <i class="fa fa-times" id="error_transcript" style="display:none;"></i></button>
                    </div>
                </div>
                <div style="height:10px;">&nbsp;</div>
                <div class="row">
                    <div class="col-xs-4">
                        <button id="btn_student_hr" class="btn btn-sm btn-block btn-primary">ทะเบียนบ้านนักเรียน <i class="fa fa-check-circle" id="check_student_hr" style="display:none;"></i> <i class="fa fa-times" id="error_student_hr" style="display:none;"></i></button>
                    </div>
                    <div class="col-xs-4">
                        <button id="btn_gradecert" class="btn btn-sm btn-block btn-primary">ใบรับรองผลการเรียน <i class="fa fa-check-circle" id="check_gradecert" style="display:none;"></i> <i class="fa fa-times" id="error_gradecert" style="display:none;"></i></button>
                    </div>
                </div>
                <div style="height:10px;">&nbsp;</div>
                <hr style="margin-top:0px;margin-bottom:15px;">

                <div class="infoContainer">
                    <div class="info" id="info_image">
                    </div>
                    <div class="info" id="info_citizen_card" style="display:none;">
                        <p>เลขประจำตัวประชาชน: <b>{{$data->citizen_id}}</b> </p>
                        <p>วัน/เดือน/ปีเกิด: <b>{{$data->birthdate["day"]}} / {{$data->birthdate["month"]}} / {{$data->birthdate["year"]}}</b> </p>
                        <p>ที่อยู่ปัจจุบัน: <b>{{$data->address["home"]["home_address"]}} หมู่ {{$data->address["home"]["home_moo"]}} ซอย {{$data->address["home"]["home_soi"]}} ถนน{{$data->address["home"]["home_road"]}} ตำบล{{$data->address["home"]["home_subdistrict"]}} อำเภอ{{$data->address["home"]["home_district"]}} จังหวัด{{$data->address["home"]["home_province"]}} {{$data->address["home"]["home_postcode"]}}</b> </p>
                        <p>ที่อยู่ตามทะเบียนบ้าน: <b>{{$data->address["current"]["current_address"]}} หมู่ {{$data->address["current"]["current_moo"]}} ซอย {{$data->address["current"]["current_soi"]}} ถนน{{$data->address["current"]["current_road"]}} ตำบล{{$data->address["current"]["current_subdistrict"]}} อำเภอ{{$data->address["current"]["current_district"]}} จังหวัด{{$data->address["current"]["current_province"]}} {{$data->address["current"]["current_postcode"]}}</b> </p>
                    </div>
                    <div class="info" id="info_transcript" style="display:none;">
                        <p>เลขประจำตัวประชาชน: <b>{{$data->citizen_id}}</b> </p>
                        <p>โรงเรียน: <b>{{$data->school}}</b> จังหวัด: <b>{{$data->school_province}}</b> </p>
                        <p>เกรดเฉลี่ยสะสม 5 ภาคเรียน: <b>{{$data->gpa}}</b> </p>
                    </div>
                    <div class="info" id="info_student_hr" style="display:none;">
                        <p>เลขประจำตัวประชาชน: <b>{{$data->citizen_id}}</b> </p>
                        <p>วัน/เดือน/ปีเกิด: <b>{{$data->birthdate["day"]}} / {{$data->birthdate["month"]}} / {{$data->birthdate["year"]}}</b> </p>
                        <p>ที่อยู่ปัจจุบัน: <b>{{$data->address["home"]["home_address"]}} หมู่ {{$data->address["home"]["home_moo"]}} ซอย {{$data->address["home"]["home_soi"]}} ถนน{{$data->address["home"]["home_road"]}} ตำบล{{$data->address["home"]["home_subdistrict"]}} อำเภอ{{$data->address["home"]["home_district"]}} จังหวัด{{$data->address["home"]["home_province"]}} {{$data->address["home"]["home_postcode"]}}</b> </p>
                        <p>ที่อยู่ตามทะเบียนบ้าน: <b>{{$data->address["current"]["current_address"]}} หมู่ {{$data->address["current"]["current_moo"]}} ซอย {{$data->address["current"]["current_soi"]}} ถนน{{$data->address["current"]["current_road"]}} ตำบล{{$data->address["current"]["current_subdistrict"]}} อำเภอ{{$data->address["current"]["current_district"]}} จังหวัด{{$data->address["current"]["current_province"]}} {{$data->address["current"]["current_postcode"]}}</b> </p>
                    </div>
                    <div class="info" id="info_gradecert" style="display:none;">
                        <p>โรงเรียน: <b>{{$data->school}}</b> จังหวัด: <b>{{$data->school_province}}</b> </p>
                        <p>เกรดเฉลี่ยสะสม 5 ภาคเรียน: <b>{{$data->gpa}}</b> </p>
                        @foreach($data->quota_grade as $subject => $subject_grade)
                            <p>เกรดเฉลี่ยวิชา {{$subject}}: <b>{{$subject_grade}}</b> </p>
                        @endforeach
                    </div>
                </div>

                <hr />
                <form action="/applicants/status/{{ $data['_id'] }}" method="post">
                    <input type="hidden" value="1" name="status">

                    {{ csrf_field() }}
                </form>
                <div class="row">
                    <div class="col-xs-6">
                        <button id="btnAcceptApplication" class="btn btn-block btn-success disabled">Accept Submission</button>
                    </div>
                    <div class="col-xs-6">
                        <button id="btnThrowIntoRejectBin" class="btn btn-block btn-danger btn-reject disabled">Reject Submission</button>
                    </div>
                </div>

            </div>
            <div class="col-xs-6">
                <div class="documentContainer" align="center">
                    <div class="document" id="document_image">
                        <small class="text-muted">รูปถ่าย</small>
                        <img src="{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'image') }}" class="img-responsive zoomableImage">
                    </div>
                    <div class="document" id="document_citizen_card" style="display:none;">
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
                    <div class="document" id="document_gradecert" style="display:none;">
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

    @endif
@endsection

@section('additional_scripts')
    <script>
        var currentDoc = "image";
        var acceptedDocs = [];
        var rejectedDocs = [];
        var rejectedReasons = [];
        var totalDocuments = 5;
        var csrfToken = "<?php echo csrf_token(); ?>";

        function isAcceptable(){
            // Count accepted docs - should be equal to the number of total docs.
            // The number of rejected docs should be zero
            if(acceptedDocs.length == totalDocuments && rejectedDocs.length == 0){
                return true;
            }else{
                return false;
            }
        }

        function checkAndEnableGrandButtons(){
            console.log("Total number of documents: " +  totalDocuments + ", Accepted: " + acceptedDocs.length + ", Rejected: " + rejectedDocs.length);
            if(parseInt(acceptedDocs.length) + parseInt(rejectedDocs.length) == totalDocuments){
                console.log("Everything checked");
                // Checked everything
                if(isAcceptable() === true){
                    console.log("Everything checks out");
                    $("#btnAcceptApplication").removeClass("disabled");
                    $("#btnThrowIntoRejectBin").removeClass("disabled").addClass("disabled");
                }else{
                    $("#btnAcceptApplication").removeClass("disabled").addClass("disabled");
                    $("#btnThrowIntoRejectBin").removeClass("disabled");
                }
            }else{
                // N.O.P.E.
                $("#btnAcceptApplication").removeClass("disabled").addClass("disabled");
                $("#btnThrowIntoRejectBin").removeClass("disabled").addClass("disabled");
            }
        }

        $("#btnAcceptApplication").click(function(e){
            e.preventDefault();
            // SUBMIT Everything
            console.log("Sending acceptance");

            $.ajax({
                url: '/applicants/status/{{ $data['_id'] }}/',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    status: "1"
                },
                error: function (request, status, error) {
                    console.log("(" + request.status + ") Exception:" + request.responseText);
                },
                dataType: 'json',
                success: function(data) {

                    // Tell the user that everything went well
                    console.log("AJAX complete - sent accept all");

                }
            });
        });

        $("#btnThrowIntoRejectBin").click(function(e){
            e.preventDefault();
            // REJECT the application
            console.log("Sending rejection");
            $.ajax({
                url: '/applicants/status/{{ $data['_id'] }}/',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    status: "-1"
                },
                error: function (request, status, error) {
                    console.log("(" + request.status + ") Exception:" + request.responseText);
                },
                dataType: 'json',
                success: function(data) {

                    // Tell the user that everything went well
                    console.log("AJAX complete - sent reject all");

                }
            });
        });

        $("#btn_image").click(function(e){
            e.preventDefault();
            showDocument("image");
        });
        $("#btn_citizen_card").click(function(e){
            e.preventDefault();
            showDocument("citizen_card");
        });
        $("#btn_transcript").click(function(e){
            e.preventDefault();
            showDocument("transcript");
        });
        $("#btn_student_hr").click(function(e){
            e.preventDefault();
            showDocument("student_hr");
        });
        $("#btn_gradecert").click(function(e){
            e.preventDefault();
            showDocument("gradecert");
        });

        $("#btnAcceptDoc").click(function(e){
            e.preventDefault();
            if($.inArray(currentDoc, acceptedDocs) == -1){
                console.log("Pushed [" + currentDoc + "] to accepted documents list");
                acceptedDocs.push(currentDoc);
                $("#error_" + currentDoc).hide();
                $("#check_" + currentDoc).show();

                $.ajax({
                    url: '/applicants/documents/{{ $data['_id'] }}/' + currentDoc,
                    data: {
                        _token: csrfToken,
                        action: "1"
                    },
                    error: function (request, status, error) {
                        console.log("(" + request.status + ") Exception:" + request.responseText);
                    },
                    dataType: 'json',
                    success: function(data) {

                        // Tell the user that everything went well
                        console.log("AJAX complete - accepted " + currentDoc);

                    },
                    type: 'POST'
                });

                // Remove from reject bin (& rejected reasons bin)
                var rejectIndex = rejectedDocs.indexOf(currentDoc);
                if (rejectIndex > -1) {
                    rejectedDocs.splice(rejectIndex, 1);
                    rejectedReasons.splice(rejectIndex, 1);
                    console.log("Removed [" + currentDoc + "] from the rejected documents list");
                }

            }
            checkAndEnableGrandButtons();
        });

        $("#btnRejectDoc").click(function(e){
            e.preventDefault();
            bootbox.prompt({
                title: "ปฎิเสธเอกสาร: กรุณาระบุเหตุผล",
                inputType: 'textarea',
                callback: function (reason) {
                    if(reason !== null){
                        // Got something
                        $("#error_" + currentDoc).show();
                        $("#check_" + currentDoc).hide();

                        // Save reject & reject reason (if not exists)
                        if($.inArray(currentDoc, rejectedDocs) == -1){
                            console.log("Added [" + currentDoc + "] to the rejected documents list");
                            rejectedDocs.push(currentDoc);
                            rejectedReasons.push(reason);

                            $.ajax({
                                url: '/applicants/{{ $data['_id'] }}/' + currentDoc,
                                data: {
                                    _token: csrfToken,
                                    action: "-1",
                                    comment: reason
                                },
                                error: function (request, status, error) {
                                    console.log("(" + request.status + ") Exception:" + request.responseText);
                                },
                                dataType: 'json',
                                success: function(data) {

                                    // Tell the user that everything went well
                                    console.log("AJAX complete - rejected " + currentDoc);

                                },
                                type: 'POST'
                            });
                        }

                        // Remove from accepted documents list (if exists):
                        var acceptedIndex = acceptedDocs.indexOf(currentDoc);
                        if (acceptedIndex > -1) {
                            acceptedDocs.splice(acceptedIndex, 1);
                            console.log("Removed [" + currentDoc + "] from the accepted documents list");
                        }
                    }

                }
            });
            checkAndEnableGrandButtons();
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
                message: "\
                    <div class='row'>\
                        <div class='col-xs-3'>\
                            <span class='text-muted'>รูปถ่ายนักเรียน</span>\
                            <img src='{{ App\Http\Controllers\ApplicantController::renderDocument($data['_id'], 'image') }}' class='img-responsive zoomableImage'> \
                        </div>\
                        <div class='col-xs-9'>\
                            <span class='text-muted'>เอกสาร</span>\
                            <img src='" + $(this).attr("src") + "' style='width:100%;' /> \
                        </div>\
                    </div>",
                size: 'large'
            });
        });
    </script>
@endsection
