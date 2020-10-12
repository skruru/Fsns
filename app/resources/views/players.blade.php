@extends('layouts.app')

@section('teammenu')
    <div class="">
        @foreach ($players as $player)
        <p><a href="/myPage/{{$player['id']}}">{{$player['name']}}</a></p>
        @endforeach
        <p><a href="/">トップへ</a></p>
        <p><a href="/player">player新規作成</a></p>
    </div>
@endsection
