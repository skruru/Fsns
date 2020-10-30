@extends('team')

@section('show')

<nav class="items_nav">
    <ul class="d-flex justify-content-end">
        <li class="team_items"><a href="/team/{{$id}}/days/?y={{$tt['tmY']}}&&m={{$tt['tmM']}}">Days</a></li>
        <li class="team_items show_nav"><a href="/team/{{$id}}/movie">Movie</a></li>
        <li class="team_items"><a href="/team/{{$id}}/blog">Blog</a></li>
        <li class="team_items"><a href="/team/{{$id}}/contact">Contact</a></li>
    </ul>
</nav>

<div class="items_bord">

    <p class="btn pb-1 pt-1 pr-2 pl-2 bg-primary"><a class="d-block" href="/team/{{$id}}/movie/upload/">動画のアップロード</a></p>
    @isset($movies)
        @foreach($movies as $movie)
            <dl class="border bg-light">
                <dt>{{$movie->title}}</dt>
                <dd>{{$movie->movie}}</dd>
                <dd class="btn pb-1 pt-1 pr-2 pl-2"><a href="/team/{{$id}}/movie/movieup/{{$movie->id}}">変更/削除</a></dd>
            </dl>
        @endforeach
    @endisset

</div>
@endsection
