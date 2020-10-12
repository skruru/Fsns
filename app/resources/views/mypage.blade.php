@extends('layouts.app')

@section('top')
<div class="container-fluid">
<div class="">
    <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-primary" style="text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">マイページ</h1>
        <div class="">
            <p>アカウント名：{{$users->name}}</p>
            <p>活動地域：{{$users->area}}</p>
            <p>性別：{{$users->gender}}</p>
            <p>フットサル歴{{$users->experience}}</p>
        </div>
        <p><a href="/myPage/account">編集する</a></p>
        <p><a href="/players">playersにもどる</a></p>
    </div>
</div>
</div>
@endsection
