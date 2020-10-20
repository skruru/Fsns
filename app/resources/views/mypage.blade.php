@extends('layouts.app')

@section('content')
<div class="container-fluid">
<div class="">
    <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-primary" style="text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">マイページ</h1>
        <div class="">
            <p>アカウント名：{{$users->name}}</p>
            <p>活動地域：{{$users->area}}</p>
            <p>性別：{{$users->gender}}</p>
            <p>フットサル歴：{{$users->experience}}</p>
        <p>フォローチーム：<a href="/followTeams/{{$users->id}}">{{$follows}}チーム</a></p>
            <p>twitter：{{$users->twitter}}</p>
            <p>instagram：{{$users->instagram}}</p>
            <p>facebook：{{$users->facebook}}</p>
        </div>
        <form action="/myPage/{{$users->id}}/account" method="POST">
            @csrf
            <input type="submit" value="編集する">
        </form>
        <p><a href="/players">playersにもどる</a></p>
    </div>
</div>
</div>
@endsection
