@extends('layouts.master')

@section('content')
<form action="/login" method="post">
    <input type="text" name="username" placeholder="Username"><br />
    <input type="password" name="password" placeholder="Password"><br />
    {{ csrf_field() }}
    <input type="submit" value="Login">
</form>
@endsection
