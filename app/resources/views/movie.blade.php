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

    <div class="">
        <p>movie</p>
    </div>
    <p><a href="/team/{{$id}}/movie/upload/">動画のアップロード</a></p>
    @isset($movies)
        @foreach($movies as $movie)
            <dl class="border">
                <dt>{{$movie->title}}</dt>
                <dd>{{$movie->movie}}</dd>
                <dd><a href="/team/{{$id}}/movie/movieup/{{$movie->id}}">変更/削除</a></dd>
            </dl>
        @endforeach
    @endisset

</div>
@endsection
