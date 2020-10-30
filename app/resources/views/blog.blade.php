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

    <div class="">
        <p>blog</p>
    </div>
    <p><a href="/team/{{$id}}/blog/post">投稿する</a></p>
    @isset($blogs)
        @foreach ($blogs as $blog)
            <dl class="border">
                <dt>{{$blog->title}}</dt>
                <dd>{{$blog->text}}</dd>
                <dd><a href="/team/{{$id}}/blog/blogup/{{$blog->id}}">変更/削除</a></dd>
            </dl>
        @endforeach
    @endisset

</div>
@endsection
