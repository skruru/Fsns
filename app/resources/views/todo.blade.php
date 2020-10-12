@extends('days')

@section('todo')
    <form action="/team/{{$item->id}}/days/?y={{$today->year}}&&m={{$today->month}}" method="POST">
    @CSRF
        <select name="month" id="">
            @for($i = 1;$i <= 12;$i++)
            <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>月
        <select name="day" id="">
            @for($i = 1;$i <= 31;$i++)
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
        <input type="hidden" name="id" value="{{$item->id}}">
        <input type="submit" value="追加">
    </form>
    <p><a href="/team/{{$item->id}}/days">キャンセル</a></p>
</dl>
@endsection
