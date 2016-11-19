@extends('layouts.master')

@section('content')
    มีผู้สมัครรอการพิจารณา {{ count($data) }} คน

    @if(count($data) == 0)
        <div class="well">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div style="display:flex;justify-content:center;align-items:center;">
                        <div>ไม่มีผู้สมัครรอการพิจารณา</div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @for($i=0;$i<3;$i++)
            <div class="well">
                <div class="row">
                    <div class="col-md-12">
                        นาย... ... {{ $i }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <a href="/applicants/123456"><button class="btn btn-block btn-info">ตรวจสอบ</button></a>
                    </div>
                </div>
            </div>
        @endfor
    @endif

@endsection
