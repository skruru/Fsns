@extends('team')

@section('show')

<div class="">
    <p>movie</p>
</div>
<form action="/team/{{$id}}/movie/mup/{{$movie->id}}" method="POST">
    @csrf
    <p>タイトル<input type="text" name="title" value="{{$movie->title}}"></p>
    <p>動画を選択<input type="file" name="movie"></p>
    <input type="hidden" name="team_id" value="{{$id}}">
    <p><input type="submit" value="変更する"></p>
</form>
<form action="/team/{{$id}}/movie/mdel/{{$movie->id}}" method="POST">
    @csrf
    <p><input type="submit" value="削除する"></p>
</form>

@endsection
