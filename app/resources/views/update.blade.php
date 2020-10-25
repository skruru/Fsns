@extends('layouts.app')

@section('content')
<div class="header">
    <form action="/team/login/{{$id}}" method="POST">
        @csrf
        <h1 class="team_ttl">
            チーム名:<input type="text" name="team_name" value="{{$team->team_name}}">
            @isset($err_team_name)
                <p class="text-danger">{{$err_team_name}}</p>
            @endisset
        </h1>
        <div class="header_content">
            <p class="header_content_img"><img src="https://placehold.jp/150x150.png" alt=""><input type="file" name="team_img"></p>
            <p>
                <p class="header_content_area">
                    活動地域：<input type="text" name="team_area" value="{{$team->team_area}}">
                    @isset($err_team_area)
                        <p class="text-danger">{{$err_team_area}}</p>
                    @endisset
                </p>
                <p class="header_content_txt">
                    活動内容：<textarea name="team_contents" placeholder="{{$team->team_contents}}"></textarea>
                    @isset($err_team_contents)
                        <p class="text-danger">{{$err_team_contents}}</p>
                    @endisset
                </p>
            </p>
            <ul class="team_link">
                <li class="d-flex">
                    <a href="twitter">t</a>
                    <input type="text" name="twitter" value="{{$team->twitter}}">
                </li>
                <li class="d-flex">
                    <a href="instagram">i</a>
                    <input type="text" name="instagram" value="{{$team->instagram}}">
                </li>
                <li class="d-flex">
                    <a href="facebook">f</a>
                    <input type="text" name="facebook" value="{{$team->facebook}}">
                </li>
            </ul>
        </div>
        <p>
            チームパスワード：<input type="password" name="team_password" value="{{$team->team_password}}">
            @isset($err_team_password)
                <p class="text-danger">{{$err_team_password}}</p>
            @endisset
        </p>
        <p>
            メールアドレス：<input type="mail" name="mail" value="{{$team->mail}}">
            @isset($err_team_mail)
                <p class="text-danger">{{$err_team_mail}}</p>
            @endisset
        </p>
        <input type="submit" value="更新する">
    </form>
</div>
<p><a href="/team/{{$id}}">キャンセル</a></p><br>
<form action="/delete/{{$id}}" method="POST">
@csrf
<input class="bg-danger" type="submit" value="削除する">
</form>
@endsection
