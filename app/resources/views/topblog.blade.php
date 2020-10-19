@extends('layouts.app')

@section('content')
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

<div class="mx-auto border" style="max-width:1200px">
    @php $i=0; @endphp
    @foreach ($blogs as $blog)
    <div class="border">
    <p>チーム：<a href="/team/{{$blog[0]->team_id}}">{{$team[$i][0]->team_name}}</a></p>
    <p>タイトル：<a href="/team/{{$blog[0]->team_id}}/blog">{{$blog[0]->title}}</a></p>
    <p>内容：{{$blog[0]->text}}</p>
    <p>最終更新：{{$blog[0]->updated_at}}</p>
    </div>
    @php $i++; @endphp
    @endforeach
    </div>
</div>
@endsection
