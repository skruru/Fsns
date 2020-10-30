@extends('team')

@section('show')

<nav class="items_nav">
    <ul class="d-flex justify-content-end">
        <li class="team_items"><a href="/team/{{$id}}/days/?y={{$tt['tmY']}}&&m={{$tt['tmM']}}">Days</a></li>
        <li class="team_items"><a href="/team/{{$id}}/movie">Movie</a></li>
        <li class="team_items show_nav"><a href="/team/{{$id}}/blog">Blog</a></li>
        <li class="team_items"><a href="/team/{{$id}}/contact">Contact</a></li>
    </ul>
</nav>

<div class="items_bord">

    <p class="btn pb-1 pt-1 pr-2 pl-2 bg-primary"><a href="/team/{{$id}}/blog/post">投稿する</a></p>
    @isset($blogs)
        @foreach ($blogs as $blog)
            <dl class="border bg-light">
                <dt>{{$blog->title}}</dt>
                <dd>{{$blog->text}}</dd>
                <dd class="btn pb-1 pt-1 pr-2 pl-2"><a href="/team/{{$id}}/blog/blogup/{{$blog->id}}">変更/削除</a></dd>
            </dl>
        @endforeach
    @endisset

</div>
@endsection
