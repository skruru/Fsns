@extends('team')

@section('show')
<div class="">
    <p>movie</p>
</div>
<p><a href="/team/{{$item->id}}/movie/upload">動画のアップロード</a></p>
<p>{{$movies->title}}</p>
<p>{{$movies->movie}}</p>
@endsection
