@extends('team')

@section('show')

<nav class="items_nav">
    <ul class="d-flex justify-content-end">
        <li class="team_items"><a href="/team/{{$id}}/days/?y={{$tt['tmY']}}&&m={{$tt['tmM']}}">Days</a></li>
        <li class="team_items"><a href="/team/{{$id}}/movie">Movie</a></li>
        <li class="team_items"><a href="/team/{{$id}}/blog">Blog</a></li>
        <li class="team_items show_nav"><a href="/team/{{$id}}/contact">Contact</a></li>
    </ul>
</nav>

<div class="items_bord">

    <div class="">
        <form action="" method="POST">
            @csrf
            <p>
                日程<input class="ml-3" type="text" name="contact_day"><br>
                @isset($err_day)
                    <p class="text-danger">{{$err_day}}</p>
                @endisset
            </p>
            <p>
                <p>内容</p>
                <textarea id="" cols="30" rows="10" name="contact_text"></textarea><br>
                @isset($err_text)
                    <p class="text-danger">{{$err_text}}</p>
                @endisset
                <input class="btn pb-1 pt-1 pr-2 pl-2 mt-2" type="submit" value="送信">
            </p>
        </form>
    </div>

</div>
@endsection
