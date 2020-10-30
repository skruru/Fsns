@extends('layouts.app')

@section('content')
<form action="/serch" method="POST">
    @csrf
    <p>チーム検索</p>
    <input type="text" class="form-control col-md-5" placeholder="検索したいチーム名を入力してください" name="team_name">
    <button type="submit" class="btn bg-primary col-md-5 mt-1 font-weight-bold">検索</button>
</form>
<br><br>
<div class="">
    @foreach ($teams as $team)
        <p><a href="/team/{{$team['id']}}">{{$team['team_name']}}</a></p>
    @endforeach
    <p><a href="/create">チーム作成</a></p>
    <p><a href="/">トップへ</a></p>
</div>

@endsection
