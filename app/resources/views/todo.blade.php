@extends('days')

@section('todo')

@if(isset($err))
    <p class="text-danger">{{$err}}</p>
@endif
<form action="/team/{{$id}}/days/?y={{$today->year}}&&m={{$today->month}}" method="POST">
    @csrf
    {{$m}}月
    <input type="hidden" name="month" value="{{$m}}">
    <select class="ml-1" name="day" id="">
        @for($i = 1;$i <= $daysInMonth;$i++)
            <option value="{{$i}}">{{$i}}</option>
        @endfor
    </select>日
    <select class="ml-2" name="start" id="">
        @for($i = 0;$i <= 24;$i++)
            <option value="{{$i}}">{{$i}}時</option>
        @endfor
    </select> ~
    <select name="end" id="">
        @for($i = 0;$i <= 24;$i++)
            <option value="{{$i}}">{{$i}}時</option>
        @endfor
    </select>
    <input class="ml-2" type="text" name="todo">
    <input type="hidden" name="id" value="{{$id}}">
    <input class="btn bg-primary pb-1 pt-1 pr-2 pl-2 ml-2" type="submit" value="記入する">
</form>
<p class="cansel"><a href="/team/{{$id}}/days/?y={{$tt['tmY']}}&&m={{$tt['tmM']}}">キャンセル</a></p>
@endsection
