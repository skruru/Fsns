@extends('layouts.app')

@section('content')

<div>
    <form action="/teams" method="POST">
        @csrf
        <h2>
            チーム名:<input class="ml-3" type="text" name="team_name">
            @isset($err_team_name)
                <p class="text-danger">{{$err_team_name}}</p>
            @endisset
        </h2>
        <p class="header_content_img"><img src="https://placehold.jp/150x150.png" alt=""><input class="ml-3" class="ml-3" type="file" name="team_img"></p>
        <p>
            <p>
                活動地域：<input class="ml-3" type="text" name="team_area">
                @isset($err_team_area)
                    <p class="text-danger">{{$err_team_area}}</p>
                @endisset
            </p>
            <p>
                <p>活動内容：</p>
                <textarea name="team_contents"></textarea>
                @isset($err_team_contents)
                    <p class="text-danger">{{$err_team_contents}}</p>
                @endisset
            </p>
        </p>
        <ul>
            <li class="d-flex align-items-baseline">
                <p>twitter:</p>
                <input class="ml-3" type="text" name="twitter">
            </li>
            <li class="d-flex align-items-baseline">
                <p>instagram:</p>
                <input class="ml-3" type="text" name="instagram">
            </li>
            <li class="d-flex align-items-baseline">
                <p>facebook:</p>
                <input class="ml-3" type="text" name="facebook">
            </li>
        </ul>
        <p>
            チームパスワード：<input class="ml-3" type="password" name="team_password">
            @isset($err_team_password)
                <p class="text-danger">{{$err_team_password}}</p>
            @endisset
        </p>
        <p>
            メールアドレス：<input class="ml-3" type="mail" name="mail">
            @isset($err_team_mail)
                <p class="text-danger">{{$err_team_mail}}</p>
            @endisset
        </p>
        <input class="btn pb-1 pt-1 pr-2 pl-2 bg-primary" type="submit" value="作成する">
    </form>
</div>
<p class="mt-3"><a href="/teams">キャンセル</a></p>

@endsection
