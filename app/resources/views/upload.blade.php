@extends('team')

@section('show')
<div class="">
    <p>movie</p>
</div>
<form action="/team/{{$id}}/movie" method="POST">
    @csrf
    <p>タイトル<input type="text" name="title"></p>
    <p>動画を選択<input type="file" name="movie"></p>
    <input type="hidden" name="team_id" value="{{$id}}">
    <input type="submit" value="投稿する">
</form>
<br>
<p><a href="/team/{{$id}}/movie">戻る</a></p>

@endsection
