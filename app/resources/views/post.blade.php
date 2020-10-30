@extends('team')

@section('show')

<nav class="items_nav">
    <ul class="d-flex justify-content-end">
        <li class="team_items"><a href="/team/{{$id}}/days/?y={{$tt['tmY']}}&&m={{$tt['tmM']}}">Days</a></li>
        <li class="team_items"><a href="/team/{{$id}}/movie">Movie</a></li>
        <li class="team_items show_nav"><a href="/team/{{$id}}/blog">Blog</a></li>
        <li class="team_items"><a href="/team/{{$id}}/contact">Contact</a></li>
    </ul>
</nav>

<div class="items_bord">

    <form action="/team/{{$id}}/blog" method="POST">
        @csrf
        <p>
            タイトル<input class="ml-3" type="text" name="title">
            @isset($err_title)
                <p class="text-danger">{{$err_title}}</p>
            @endisset
        </p>
        <p>
            <p>内容</p>
            <textarea name="text" id="" cols="30" rows="10"></textarea>
            @isset($err_text)
                <p class="text-danger">{{$err_text}}</p>
            @endisset
        </p>
        <input type="hidden" name="team_id" value="{{$id}}">
        <input class="btn pb-1 pt-1 pr-2 pl-2" type="submit" value="投稿する">
    </form>
    <br>
    <p><a href="/team/{{$id}}/blog">戻る</a></p>

</div>
@endsection
