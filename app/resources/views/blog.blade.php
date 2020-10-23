@extends('team')

@section('show')
<div class="">
    <p>blog</p>
</div>
<p><a href="/team/{{$id}}/blog/post">投稿する</a></p>
@isset($blogs)
    @foreach ($blogs as $blog)
        <dl class="border">
            <dt>{{$blog->title}}</dt>
            <dd>{{$blog->text}}</dd>
            <dd><a href="/team/{{$id}}/blog/blogup/{{$blog->id}}">変更/削除</a></dd>
        </dl>
    @endforeach
@endisset
@endsection
