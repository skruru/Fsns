@extends('layouts.app')

@section('teammenu')
    <div class="">
        @foreach ($teams as $team)
        <p><a href="/team/{{$team['id']}}">{{$team['team_name']}}</a></p>
        @endforeach
        <p><a href="/create">チーム作成</a></p>
        <p><a href="/">トップへ</a></p>
    </div>
    <form action="{{url('/serch')}}" method="POST">
    {{ csrf_field()}}
    {{method_field('get')}}
    <div class="form-group">
    <p>検索</p>
    <input type="text" class="form-control col-md-5" placeholder="検索したい名前を入力してください" name="team_name">
    <button type="submit" class="btn btn-primary col-md-5">検索</button>
    </div>
    </form>
@endsection
