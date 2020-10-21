@extends('layouts.app')

@section('content')
    <div class="header">
        <h1 class="team_ttl">チーム名:{{$item->team_name}}</h1>
        <p>
            <a href="/update/login/{{$item->id}}">チーム編集</a>
            @if ($err != null)
            @php
                echo '<p class="text-danger">'.$err.'</p>';
            @endphp
            @endif
        </p>
        <form action="/team/{{$item->id}}/follower" method="POST">
            @csrf
            <input type="hidden" name="team_id" value="{{$item->id}}">
            <input class="bg-primary text-white" type="submit" value="フォローする">
        </form>
        <br>
        <div class="header_content">
            <p class="header_content_img"><img src="https://placehold.jp/150x150.png" alt=""></p>
            <p>
                <p class="header_content_area">活動地域：{{$item->team_area}}</p>
                <p class="header_content_txt">{{$item->team_contents}}</p>
            </p>
            <ul class="team_link d-flex">
                <li><a href="twitter">t</a></li>
                <li><a href="instagram">i</a></li>
                <li><a href="facebook">f</a></li>
            </ul>
            <p class="team_follow"><a href="/team/{{$item->id}}/follower">フォロワー</a>{{$followers}}人</p>
            <p><a href="/teams">チーム一覧へ</a></p>
        </div>
    </div>
    <section class="items">
        <nav class="items_nav">
            <ul class="d-flex justify-content-end">
                <li><a href="/team/{{$item->id}}/days/?y={{$tt['tmY']}}&&m={{$tt['tmM']}}">Days</a></li>
                <li><a href="/team/{{$item->id}}/movie">Movie</a></li>
                <li><a href="/team/{{$item->id}}/blog">Blog</a></li>
                <li><a href="/team/{{$item->id}}/contact">Contact</a></li>
            </ul>
        </nav>
        <div class="items_bord">
            @yield('show')
        </div>
    </section>
@endsection
