@extends('layouts.app')

@section('teammenu')
        <div class="header">
            <form action="/team" method="POST">
            @csrf
                <h1 class="team_ttl">チーム名:<input type="text" name="team_name"></h1>
                <div class="header_content">
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
                </div>
                <p>チームID：<input type="text" name="team_id"></p>
                <p>チームパスワード：<input type="password" name="team_password"></p>
                <p>メールアドレス：<input type="mail" name="mail"></p>
                <input type="submit" value="作成する">
            </form>
        </div>
        <section class="items">
            <nav class="items_nav">
                <ul class="d-flex justify-content-end">
                    <li><a href="/days">Days</a></li>
                    <li><a href="/movies">Movies</a></li>
                    <li><a href="/blog">Blog</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </nav>
            <div class="items_bord bg-primary">
                こんにちは
            </div>
        </section>
@endsection
