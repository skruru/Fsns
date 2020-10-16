@extends('team')

@section('show')
<div class="">
    <p>blog</p>
</div>
<form action="/team/{{$item->id}}/blog/bup/{{$blog->id}}" method="POST">
    @csrf
    <p>タイトル<input type="text" name="title" placeholder="{{$blog->title}}"></p>
    <p>内容<textarea name="text" id="" cols="30" rows="10"></textarea></p>
    <input type="hidden" name="team_id" value="{{$item->id}}">
    <p><input type="submit" value="変更する"></p>
</form>
<form action="/team/{{$item->id}}/blog/bdel/{{$blog->id}}" method="POST">
@csrf
<p><input type="submit" value="削除する"></p>
</form>
@endsection
