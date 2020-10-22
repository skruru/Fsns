@extends('layouts.app')

@section('content')
<div class="">
    <p>フォローチームの一覧</p>
    @if($teams == null)
    @php
        echo 'フォローチームはありません';
    @endphp
    @else
    @foreach ($teams as $team)
    <p><a href="/team/{{$team[0]->id}}">{{$team[0]->team_name}}</a></p>
    @endforeach
    @endif
    <p><a href="/myPage/{{$id}}">戻る</a></p>
</div>
@endsection
