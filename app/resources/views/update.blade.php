@extends('layouts.app')

@section('content')
<div class="header">
    <form action="/team/{id}}" method="POST">
    @csrf
        <input type="hidden" name="id" value="{{$item->id}}">
        <h1 class="team_ttl">チーム名:<input type="text" name="team_name" value="{{$item->team_name}}"></h1>
        <div class="header_content">
            <p class="header_content_img"><img src="https://placehold.jp/150x150.png" alt=""><input type="file" name="team_img"></p>
            <p>
                <p class="header_content_area">活動地域：<input type="text" name="team_area" value="{{$item->team_area}}"></p>
                <p class="header_content_txt">内容：<textarea name="team_contents" placeholder="{{$item->team_contents}}"></textarea></p>
            </p>
            <ul class="team_link">
                <li class="d-flex">
                    <a href="twitter">t</a>
                    <input type="text" name="twitter" value="{{$item->twitter}}">
                </li>
                <li class="d-flex">
                    <a href="instagram">i</a>
                    <input type="text" name="instagram" value="{{$item->instagram}}">
                </li>
                <li class="d-flex">
                    <a href="facebook">f</a>
                    <input type="text" name="facebook" value="{{$item->facebook}}">
                </li>
            </ul>
        </div>
        <p>チームパスワード：<input type="password" name="team_password" value="{{$item->team_password}}"></p>
        <p>メールアドレス：<input type="mail" name="mail" value="{{$item->mail}}"></p>
        <input type="submit" value="更新する">
    </form>
</div>
<p><a href="/teams">キャンセル</a></p><br>
<form action="/delete/{{$item->id}}" method="POST">
@csrf
<input class="bg-danger" type="submit" value="削除する">
</form>
@endsection
