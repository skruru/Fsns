@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-primary" style="text-align:center; font-size:1.2em; padding:24px 0px; font-weight:bold;">マイページ</h1>
        <div class="">
            <p>アカウント名：{{$user->name}}</p>
            <p>活動地域：{{$user->area}}</p>
            <p>性別：{{$user->gender}}</p>
            <p>フットサル歴：{{$user->experience}}</p>
            <p>フォローチーム：<a href="/followTeams/{{$user->id}}">{{$follow}}チーム</a></p>
            <p>twitter：{{$user->twitter}}</p>
            <p>instagram：{{$user->instagram}}</p>
            <p>facebook：{{$user->facebook}}</p>
        </div>
        @if ($id == $current_user)
            <form action="/myPage/{{$user->id}}/account" method="POST">
                @csrf
                <input type="submit" value="編集する">
            </form>
        @endif
        <p><a href="/">トップにもどる</a></p>
    </div>
</div>
@endsection
