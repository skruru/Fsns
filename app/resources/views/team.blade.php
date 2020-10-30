@extends('layouts.app')

@section('content')
<div class="header">
    <h1 class="team_ttl">チーム名:{{$team->team_name}}</h1>
    <p>
        <a href="/team/login/{{$id}}">チーム編集</a>
    </p>
    <form action="/team/{{$id}}/follower" method="POST">
        @csrf
        <input type="hidden" name="team_id" value="{{$id}}">
        @if ($follow == 1)
        <input class="bg-danger text-white" type="submit" value="フォロー解除">
        @else
        <input class="bg-primary text-white" type="submit" value="フォロー">
        @endif
    </form>
    <br>
    <div class="header_content">
        <p class="header_content_img"><img src="https://placehold.jp/150x150.png" alt=""></p>
        <p class="header_content_area">活動地域：{{$team->team_area}}</p>
        <p class="header_content_txt">活動内容：{{$team->team_contents}}</p>
        <ul class="team_link">
            <li>twitter: {{$team->twitter}}</li>
            <li>instagram: {{$team->instagram}}</li>
            <li>facebook: {{$team->facebook}}</li>
        </ul>
        <p class="team_follow"><a href="/team/{{$id}}/follower">フォロワー</a>{{$followers}}人</p>
        <p><a href="/teams">チーム一覧へ</a></p>
    </div>
</div>
<section class="items">
    @yield('show')
    <nav class="items_nav">
        <ul class="d-flex justify-content-end">
            <li class="team_items"><a href="/team/{{$id}}/days/?y={{$tt['tmY']}}&&m={{$tt['tmM']}}">Days</a></li>
            <li class="team_items"><a href="/team/{{$id}}/movie">Movie</a></li>
            <li class="team_items"><a href="/team/{{$id}}/blog">Blog</a></li>
            <li class="team_items"><a href="/team/{{$id}}/contact">Contact</a></li>
        </ul>
    </nav>
</section>
@endsection
