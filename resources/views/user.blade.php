@extends('layouts.master')

@section('content')
    @if(empty($data))
        ไม่มีข้อมูล
    @else
        {{ var_dump(App\Requirement::verifyGrade($data['plan'], $data['quota_grade'], $data['gpa'])) }}


    @endif
@endsection
