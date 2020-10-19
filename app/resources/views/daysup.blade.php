@extends('team')

@section('show')
<caption><a href="/team/{{$item->id}}/days/?y={{$today->year}}&&m={{$today->month}}">今日</a><a href="/team/{{$item->id}}/days?y={{$subY}}&&m={{$subM}}">前月</a>{{$tmM}}月 {{$tmY}}年<a href="/team/{{$item->id}}/days?y={{$addY}}&&m={{$addM}}"> 来月>></a></caption>
<table class="table table-bordered">
    <tr>
        <th scope="col" class="bg-danger text-light">Sunday</th>
        <th scope="col">Monday</th>
        <th scope="col">Tuesday</th>
        <th scope="col">Wednesday</th>
        <th scope="col">Thursday</th>
        <th scope="col">Friday</th>
        <th scope="col" class="bg-primary">Saturday</th>
    </tr>
    <tr>
        @foreach($days as $day)
            @if($day === null)
                </tr><tr>
                @continue
            @endif
            @php
                global $plan_day;
                $plan_day = '';
            @endphp
            @foreach($plans as $plan)
                @if($plan != '' && $day == $today->day && $day == $plan->day) <!---今日と予定が一緒の時--->
                    @php $plan_day = 'plan_and_today'; @endphp
                @endif
                @if($day == $today->day && $today->month == $tt['tmM']) <!---今日--->
                    @php $plan_day = 'today'; @endphp
                @endif
                @if($plan != '' && $day == $plan->day) <!---予定--->
                    @php $plan_day = 'plan_day';
                         $todo = $plan->todo;
                    @endphp
                @endif
            @endforeach
                @if($plan_day === 'plan_and_today')
                    <td scope="col" class="bg-danger">{{$day}}<p class="text-white">today</p></td>
                @elseif($plan_day === 'today')
                    <td scope="col" class="bg-secondary">{{$day}}<p class="text-white">today</p></td>
                @elseif($plan_day === 'plan_day')
                    <td scope="col" class="bg-primary">{{$day}}<p class="text-white">{{$todo}}</p></td>
                @else
                <td scope="col" class="">{{$day}}</td>
                @endif
        @endforeach
    </tr>
</table>

@yield('todo')
<form action="/team/{{$item->id}}/days/todo?m={{$today->month}}" method="POST" class="border">
@csrf
    <p><select name="month" id="">
            @for($i = 1;$i <= 12;$i++)
                @if($plana->month == $i)
                    <option value="{{$i}}" selected>{{$i}}</option>
                @else
                    <option value="{{$i}}">{{$i}}</option>
                @endif
            @endfor
    </select>月
    <select name="day" id="">
        @for($i = 1;$i <= 31;$i++)
        @if($plana->day == $i)
        <option value="{{$i}}"  selected>{{$i}}</option>
        @else
        <option value="{{$i}}">{{$i}}</option>
        @endif
        @endfor
    </select>日
    <select name="start" id="">
        @for($i = 0;$i <= 24;$i++)
        @if($plana->start == $i)
        <option value="{{$i}}" selected>{{$i}}時</option>
        @else
        <option value="{{$i}}">{{$i}}時</option>
        @endif
        @endfor
    </select>~
    <select name="end" id="">
        @for($i = 0;$i <= 24;$i++)
        @if($plana->end == $i)
        <option value="{{$i}}" selected>{{$i}}時</option>
        @else
        <option value="{{$i}}">{{$i}}時</option>
        @endif
        @endfor
    </select>
    <input type="text" name="todo" placeholder="{{$plana->todo}}"></p>
    <input type="hidden" name="team_id" value="{{$plana->team_id}}">
    <input type="hidden" name="todo_id" value="{{$plana->id}}">
    <p><input type="submit" value="変更する"></p>
</form>
<form action="/team/{{$item->id}}/days/{{$plana->id}}/delete" method="POST">
@csrf
    <p><input type="submit" value="削除する"></p>
</form>
@endsection
