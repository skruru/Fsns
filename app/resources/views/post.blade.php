@extends('team')

@section('show')
<div class="">
    <p>blog</p>
</div>
<form action="/team/{{$id}}/blog" method="POST">
    @csrf
    <p>タイトル<input type="text" name="title"></p>
    <p>内容<textarea name="text" id="" cols="30" rows="10"></textarea></p>
    <input type="hidden" name="team_id" value="{{$id}}">
    <input type="submit" value="投稿する">
</form>
<br>
<p><a href="/team/{{$id}}/blog">戻る</a></p>

@endsection
