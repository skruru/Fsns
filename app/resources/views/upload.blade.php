@extends('team')

@section('show')
<div class="">
    <p>movie</p>
</div>
<form action="/team/{{$item->id}}/movie" method="POST">
@csrf
<p>タイトル<input type="text" name="title"></p>
<p>動画を選択<input type="file" name="movie"></p>
<input type="hidden" name="team_id" value="{{$item->id}}">
<input type="submit" value="投稿する">
</form>
@endsection
