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

    <form action="/team/{{$id}}/movie/mup/{{$movie->id}}" method="POST">
        @csrf
        <p>
            タイトル<input class="ml-3" type="text" name="title" value="{{$movie->title}}">
            @isset($err_title)
                <p class="text-danger">{{$err_title}}</p>
            @endisset
        </p>
        <p>
            動画を選択<input class="ml-3" type="file" name="movie">
            @isset($err_movie)
                <p class="text-danger">{{$err_movie}}</p>
            @endisset
        </p>
        <input type="hidden" name="team_id" value="{{$id}}">
        <p><input class="btn pb-1 pt-1 pr-2 pl-2" type="submit" value="変更する"></p>
    </form>
    <form action="/team/{{$id}}/movie/mdel/{{$movie->id}}" method="POST">
        @csrf
        <p><input class="btn del pb-1 pt-1 pr-2 pl-2" type="submit" value="削除する"></p>
    </form>
    <p><a href="/team/{{$id}}/movie">戻る</a></p>

</div>
@endsection
