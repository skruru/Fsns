@extends('team')

@section('show')
<div class="">
    <p>movie</p>
</div>
<p><a href="/team/{{$item->id}}/movie/upload">動画のアップロード</a></p>
@foreach($movies as $movie)
<p>{{$movie->title}}</p>
<p>{{$movie->movie}}</p>
@endforeach
@endsection
