@extends('layouts.app')

@section('content')
<div class="">
    <h2>Teamlogin</h2>
    <p>チームパスワードを入力してください。</p>
    @isset($err)
        <p class="text-danger">{{$err}}</p>
    @endisset
</div>
<form action="/team/{{$id}}" method="POST">
    @csrf
    <p><input type="password" name="team_password"></p>
    <p><input type="submit" value="ログイン"></p>
</form>
<p><a href="/team/{{$id}}">チームページに戻る</a></p>
@endsection
