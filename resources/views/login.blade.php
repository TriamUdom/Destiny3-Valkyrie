@extends('layouts.master')
@section('title', 'Valkyrie Login')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="well">
            <form action="/login" method="post">
                <legend><i class="fa fa-lock"></i> <b>กรุณาเข้าสู่ระบบก่อน (2/2)</b> <i class="pull-right text-muted">Operator Account</i></legend>
                <input type="text" name="username" placeholder="ชื่อผู้ใช้" class="form-control">
                <div style="height:10px;"></div>
                <input type="password" name="password" placeholder="รหัสผ่าน" class="form-control"><br />
                {{ csrf_field() }}
                <button type="submit" class="btn btn-block btn-primary">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>
</div>


@endsection
