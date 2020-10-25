@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-primary" style="text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">マイページ</h1>
        <form action="/myPage/{{$user->id}}" method="POST">
            @csrf
            <p>
                アカウント名：<input type="text" name="account_name" value="{{$user->name}}">
                @isset($err_name)
                    <p class="text-danger">{{$err_name}}</p>
                @endisset
            </p>
            <p>活動地域：<input type="text" name="account_area" value="{{$user->area}}"></p>
            <p>性別
                <input id="male" type="radio" name="gender" value="male"><label for="male">男性</label>
                <input id="female" type="radio" name="gender" value="female"><label for="female">女性</label>
            </p>
            <ul class="team_link">
                <li class="d-flex">
                    <a href="twitter">t</a>
                    <input type="text" name="twitter" value="{{$user->twitter}}">
                </li>
                <li class="d-flex">
                    <a href="instagram">i</a>
                    <input type="text" name="instagram" value="{{$user->instagram}}">
                </li>
                <li class="d-flex">
                    <a href="facebook">f</a>
                    <input type="text" name="facebook" value="{{$user->facebook}}">
                </li>
            </ul>
            <p>フットサル歴：<input type="text" name="experience" value="{{$user->experience}}"></p>
            <p>
                パスワード：<input type="password" name="account_password" value="{{$user->password}}">
                @isset($err_password)
                    <p class="text-danger">{{$err_password}}</p>
                @endisset
            </p>
            <p>
                メールアドレス：<input type="mail" name="account_mail" value="{{$user->email}}">
                @isset($err_email)
                    <p class="text-danger">{{$err_email}}</p>
                @endisset
            </p>
            <p><input type="submit" value="完了"></p>
        </form>
        <p><a href="/myPage/{{$user->id}}">キャンセル</a></p>
    </div>
</div>

@endsection
