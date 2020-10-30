@extends('layouts.app')

@section('content')
<div class="container-fluid mb-5">
    <div class="mx-auto" style="max-width:1200px">
        <h1 class="text-primary top_ttl" style="text-align:center; padding:24px 0px; font-weight:bold;">Futsal SNS</h1>
        <div class="d-flex align-items-end flex-column">
            <p class="top_nav_item">
                <a href="/teams">チーム一覧へ</a>
                <div class="top_nav_item_span">
                    <span></span><span></span>
                </div>
            </p>
            @isset($user)
                <p class="top_nav_item">
                    <a href="/myPage/{{$user->id}}">マイページへ</a>
                <div class="top_nav_item_span">
                    <span></span><span></span>
                </div>
            </p>
            @endisset
        </div>
    </div>
</div>
<div class="mx-auto" style="max-width:1200px">
    <div class="d-flex justify-content-end">
        <p class="top_show show"><a class="d-block" href="/">最新</a></p>
        <p class="top_show"><a class="d-block" href="/blogs">フォローチームのブログ</a></p>
    </div>

    <div class="mx-auto border border-primary p-2" style="max-width:1200px">
        @for($i = 0; $i <= count($blogs)-1; $i++)
        <div class="p-2 bg-light">
            <p>チーム：<a href="/team/{{$blogs[$i]->team_id}}">{{$teams[$i][0]->team_name}}</a></p>
            <p>タイトル：<a href="/team/{{$blogs[$i]->team_id}}/blog">{{$blogs[$i]->title}}</a></p>
            <p>内容：{{$blogs[$i]->text}}</p>
            <p>最終更新：{{$blogs[$i]->updated_at}}</p>
        </div>
        @endfor
    </div>
</div>

@endsection
