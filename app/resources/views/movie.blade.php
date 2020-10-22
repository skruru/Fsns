@extends('team')

@section('show')
<div class="">
    <p>movie</p>
</div>
@foreach($movies as $movie)
<dl class="border">
    <dt>{{$movie->title}}</dt>
    <dd>{{$movie->movie}}</dd>
    <dd><a href="/team/{{$item->id}}/movie/movieup/{{$movie->id}}">変更/削除</a></dd>
</dl>
@endforeach
<p><a href="/team/{{$item->id}}/movie/upload/">動画のアップロード</a></p>
@endsection
