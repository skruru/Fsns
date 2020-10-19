@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="team_ttl">チーム名:{{$item->team_name}}</h1>
        <div class="header_content">
            <h2>フォロワー一覧</h2>
            <p><a href="/myPage/{{$user->id}}">{{$user->name}}</a></p>
            <p><a href="/team/{{$id}}">チームページに戻る</a></p>
            <p><a href="/teams">チーム一覧へ</a></p>
        </div>
    </div>
@endsection
