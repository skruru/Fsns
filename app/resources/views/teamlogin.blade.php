@extends('layouts.app')

@section('content')
<div class="">
    <h2>login</h2>
</div>
<form action="/team/{{$id}}" method="POST">
    @csrf
    <p><input type="password" name="team_password"></p>
    <p><input type="submit" value="ログイン"></p>
</form>
@endsection
