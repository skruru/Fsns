@extends('layouts.app')

@section('top')
<div class="container-fluid">
<div class="">
    <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-primary" style="text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">マイページ</h1>
        <div class="">
            <p>アカウント名</p>
            <p>活動地域</p>
            <p>性別</p>
            <p>フットサル歴</p>
            <p>メールアドレス</p>
            <p>パスワード</p>
        </div>
        <p><a href="/myPage/account">完了</a></p>
    </div>
</div>
</div>
@endsection
