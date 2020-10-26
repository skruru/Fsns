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
            <p class="top_nav_item">
                <a href="/myPage/{{$user->id}}">マイページへ</a>
                <div class="top_nav_item_span">
                    <span></span><span></span>
                </div>
            </p>
        </div>
    </div>
</div>
<div class="mx-auto" style="max-width:1200px">
    <div class="d-flex justify-content-end">
        <p class="top_show"><a class="d-block" href="/">最新</a></p>
        <p class="top_show show"><a class="d-block" href="/blogs">フォローチームのブログ</a></p>
    </div>
</div>

<div class="mx-auto border border-primary p-2" style="max-width:1200px">
    @php $i=0; @endphp
    @if($blogs == null)
        <p>フォローチームはありません。</p>
    @else
        @foreach ($blogs as $blog)
            <div class="border p-2">
                <p>チーム：<a href="/team/{{$blog[0]->team_id}}">{{$team[$i][0]->team_name}}</a></p>
                <p>タイトル：<a href="/team/{{$blog[0]->team_id}}/blog">{{$blog[0]->title}}</a></p>
                <p>内容：{{$blog[0]->text}}</p>
                <p>最終更新：{{$blog[0]->updated_at}}</p>
            </div>
            @php $i++; @endphp
        @endforeach
    @endif
</div>

@endsection
