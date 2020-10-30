@extends('layouts.app')

@section('content')

<div class="header_content">
    <h2>フォロワー一覧</h2>
    @if($user == null)
    <p>フォローしているアカウントはありません。</p>
    @else
    <p><a href="/myPage/{{$user->id}}">{{$user->name}}</a></p>
    @endif
    <p><a href="/team/{{$id}}">チームページに戻る</a></p>
</div>

@endsection
