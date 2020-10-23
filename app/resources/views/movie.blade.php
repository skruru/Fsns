@extends('team')

@section('show')

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

@endsection
