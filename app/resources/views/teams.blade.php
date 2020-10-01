@extends('layouts.app')

@section('teammenu')
    <div class="">
        @foreach ($teams as $team)
        <p><a href="/team/{{$team['id']}}">{{$team['team_name']}}</a></p>
        @endforeach
        <p><a href="/create">チーム作成</a></p>
        <p><a href="/">トップへ</a></p>
    </div>
@endsection
