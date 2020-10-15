@extends('layouts.app')

@section('top')
<div class="container-fluid">
<div class="">
    <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-primary" style="text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">マイページ</h1>
        <form action="/myPage/{{$users->id}}" method="POST">
            @csrf

            <p>アカウント名：<input type="text" name="account_name" value="{{$users->name}}"></p>
            <p>活動地域：<input type="text" name="account_area" value="{{$users->area}}"></p>
            <p>性別
                <input id="male" type="radio" name="gender" value="male"><label for="male">男性</label>
                <input id="female" type="radio" name="gender" value="female"><label for="female">女性</label>
            </p>
            <ul class="team_link">
                <li class="d-flex">
                    <a href="twitter">t</a>
                    <input type="text" name="twitter" value="{{$users->twitter}}">
                </li>
                <li class="d-flex">
                    <a href="instagram">i</a>
                    <input type="text" name="instagram" value="{{$users->instagram}}">
                </li>
                <li class="d-flex">
                    <a href="facebook">f</a>
                    <input type="text" name="facebook" value="{{$users->facebook}}">
                </li>
            </ul>
            <p>フットサル歴：<input type="text" name="experience" value="{{$users->experience}}"></p>
            <p>パスワード：<input type="password" name="account_password" value="{{$users->password}}"></p>
            <p>メールアドレス：<input type="mail" name="account_mail" value="{{$users->email}}"></p>
            <p><input type="submit" value="完了"></p>
        </form>
    </div>
</div>
</div>
@endsection
