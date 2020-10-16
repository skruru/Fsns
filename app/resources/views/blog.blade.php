@extends('team')

@section('show')
<div class="">
    <p>blog</p>
</div>
<p><a href="/team/{{$item->id}}/blog/post">投稿する</a></p>
@foreach ($blogs as $blog)
<dl class="border">
    <dt>{{$blog->title}}</dt>
    <dd>{{$blog->text}}</dd>
    <dd><a href="/team/{{$item->id}}/blog/blogup/{{$blog->id}}">変更/削除</a></dd>
</dl>
@endforeach
@endsection
