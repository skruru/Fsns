@extends('layouts.app')

@section('teammenu')
        <div class="header">
            <form action="/players" method="POST">
            @csrf
                <p>アカウント名:<input type="text" name="account_name"></p>
                <div class="header_content">
                    <p>
                        <p>活動地域：<input type="text" name="account_area"></p>
                        <p>性別：
                        <input id="male" type="radio" name="gender" value="male"><label for="male">男性</label>
                        <input id="female" type="radio" name="gender" value="female"><label for="female">女性</label></p>
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
                <p>フットサル歴：<input type="text" name="experience"></p>
                <p>パスワード：<input type="password" name="account_password"></p>
                <p>メールアドレス：<input type="mail" name="account_mail"></p>
                <input type="submit" value="作成する">
            </form>
        </div>
        <p><a href="/players">キャンセル</a></p>
@endsection
