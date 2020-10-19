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
@for($i = 0; $i <= count($blogs)-1; $i++)
<div class="border">
<p>チーム：<a href="/team/{{$blogs[$i]->team_id}}">{{$teams[$i][0]->team_name}}</a></p>
<p>タイトル：<a href="/team/{{$blogs[$i]->team_id}}/blog">{{$blogs[$i]->title}}</a></p>
<p>内容：{{$blogs[$i]->text}}</p>
<p>最終更新：{{$blogs[$i]->updated_at}}</p>
</div>
@endfor
</div>

</div>
@endsection
