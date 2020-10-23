@extends('days')

@section('todo')

@if(isset($err))
    <p class="text-danger">{{$err}}</p>
@endif
<form action="/team/{{$id}}/days/?y={{$today->year}}&&m={{$today->month}}" method="POST">
    @csrf
    {{$m}}月
    <input type="hidden" name="month" value="{{$m}}">
    <select name="day" id="">
        @for($i = 1;$i <= $daysInMonth;$i++)
            <option value="{{$i}}">{{$i}}</option>
        @endfor
    </select>日
    <select name="start" id="">
        @for($i = 0;$i <= 24;$i++)
            <option value="{{$i}}">{{$i}}時</option>
        @endfor
    </select>~
    <select name="end" id="">
        @for($i = 0;$i <= 24;$i++)
            <option value="{{$i}}">{{$i}}時</option>
        @endfor
    </select>
    <input type="text" name="todo">
    <input type="hidden" name="id" value="{{$id}}">
    <input type="submit" value="追加">
</form>
<p><a href="/team/{{$id}}/days/?y={{$tt['tmY']}}&&m={{$tt['tmM']}}">キャンセル</a></p>
@endsection
