@extends('layouts.master')

@section('content')
    @if(empty($data))
        ไม่มีข้อมูล
    @else
        {{ var_dump(App\Requirement::verifyGrade($data['plan'], $data['quota_grade'], $data['gpa'])) }}

        <form action="/applicants/status/{{ $data['_id'] }}" method="post">
            <input type="hidden" value="1" name="status">
            <input type="submit" value="accept">
            {{ csrf_field() }}
        </form>
    @endif
@endsection
