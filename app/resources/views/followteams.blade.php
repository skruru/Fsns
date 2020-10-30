@extends('layouts.app')

@section('content')
<div class="">
    <h2>フォローチームの一覧</h2>
        @if($teams == null)
            <p>フォローチームはありません。</p>
        @else
            @foreach ($teams as $team)
                <p><a href="/team/{{$team->id}}">{{$team->team_name}}</a></p>
            @endforeach
        @endif
    <p><a href="/myPage/{{$id}}">戻る</a></p>
</div>
@endsection
