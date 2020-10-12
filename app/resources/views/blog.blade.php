@extends('team')

@section('show')
<div class="">
    <p>blog</p>
</div>
<p><a href="/team/{{$item->id}}/blog/post">投稿する</a></p>
<p>{{$blogs->title}}</p>
<p>{{$blogs->text}}</p>
@endsection
