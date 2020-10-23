@extends('layouts.app')

@section('content')
<div class="">
    <p>フォローチームの一覧</p>
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
