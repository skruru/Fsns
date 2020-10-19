@extends('layouts.app')

@section('top')
<div class="container-fluid">
<div class="">
    <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-primary" style="text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">Fsns</h1>
        <div class="">
            <a href="/teams">チーム一覧</a><br>
            <a href="/create">チーム作成</a><br>
            <a href="/players">playerページ</a>
        </div>
    </div>
</div>
<br><br>
<div class="mx-auto" style="max-width:1200px">
    <p><a href="/">最新</a><a href="/blogs">ブログ</a></p>
</div>

</div>
@endsection
