@extends('team')

@section('show')
<div class="">
    <p>blog</p>
</div>
<form action="/team/{{$id}}/blog" method="POST">
    @csrf
    <p>
        タイトル<input type="text" name="title">
        @isset($err_title)
            <p class="text-danger">{{$err_title}}</p>
        @endisset
    </p>
    <p>
        内容<textarea name="text" id="" cols="30" rows="10"></textarea>
        @isset($err_text)
            <p class="text-danger">{{$err_text}}</p>
        @endisset
    </p>
    <input type="hidden" name="team_id" value="{{$id}}">
    <input type="submit" value="投稿する">
</form>
<br>
<p><a href="/team/{{$id}}/blog">戻る</a></p>

@endsection
