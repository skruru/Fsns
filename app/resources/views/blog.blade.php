@extends('team')

@section('show')
<div class="">
    <p>blog</p>
</div>
<p><a href="/team/{{$item->id}}/blog/post">投稿する</a></p>
@foreach ($blogs as $blog)
<p>{{$blog->title}}</p>
<p>{{$blog->text}}</p>
@endforeach
@endsection
