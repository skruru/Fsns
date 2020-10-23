@extends('layouts.app')

@section('content')

<div class="header">
    <form action="/teams" method="POST">
        @csrf
        <h1 class="team_ttl">チーム名:<input type="text" name="team_name"></h1>
        <p class="header_content_img"><img src="https://placehold.jp/150x150.png" alt=""><input type="file" name="team_img"></p>
        <p>
            <p class="header_content_area">活動地域：<input type="text" name="team_area"></p>
            <p class="header_content_txt">内容：<textarea name="team_contents"></textarea></p>
        </p>
        <ul class="team_link">
            <li class="d-flex">
                <a href="twitter">t</a>
                <input type="text" name="twitter">
            </li>
            <li class="d-flex">
                <a href="instagram">i</a>
                <input type="text" name="instagram">
            </li>
            <li class="d-flex">
                <a href="facebook">f</a>
                <input type="text" name="facebook">
            </li>
        </ul>
        <p>チームパスワード：<input type="password" name="team_password"></p>
        <p>メールアドレス：<input type="mail" name="mail"></p>
        <input type="submit" value="作成する">
    </form>
</div>
<br>
<p><a href="/teams">キャンセル</a></p>

@endsection
