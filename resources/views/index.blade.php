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
        @foreach($data as $row)
        <div class="well">
            <div class="row">
                <div class="col-md-6">
                    {{ App\UIHelper::formatTitle($row['title']) }} {{ $row['fname'] }} {{ $row['lname'] }}
                </div>
                <div class="col-md-6">
                    {{ $row['school_province'] }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="/applicants/views/{{ $row['_id'] }}"><button class="btn btn-block btn-info">ตรวจสอบ</button></a>
                </div>
            </div>
        </div>
        @endforeach
    @endif

@endsection
