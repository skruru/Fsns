@extends('team')

@section('show')

<nav class="items_nav">
    <ul class="d-flex justify-content-end">
        <li class="team_items show_nav"><a href="/team/{{$id}}/days/?y={{$tt['tmY']}}&&m={{$tt['tmM']}}">Days</a></li>
        <li class="team_items"><a href="/team/{{$id}}/movie">Movie</a></li>
        <li class="team_items"><a href="/team/{{$id}}/blog">Blog</a></li>
        <li class="team_items"><a href="/team/{{$id}}/contact">Contact</a></li>
    </ul>
</nav>

<div class="items_bord">

    <caption><a href="/team/{{$id}}/days/?y={{$today->year}}&&m={{$today->month}}">今日</a><a href="/team/{{$id}}/days?y={{$subY}}&&m={{$subM}}">前月</a>{{$m}}月 {{$y}}年<a href="/team/{{$id}}/days?y={{$addY}}&&m={{$addM}}"> 来月>></a></caption>
    <table class="table table-bordered">
        <tr>
            <th scope="col" class="bg-danger text-light">Sunday</th>
            <th scope="col">Monday</th>
            <th scope="col">Tuesday</th>
            <th scope="col">Wednesday</th>
            <th scope="col">Thursday</th>
            <th scope="col">Friday</th>
            <th scope="col" class="bg-info">Saturday</th>
        </tr>
        <tr>
            @foreach($days as $day)
                @if($day === null)
                    </tr><tr>
                    @continue
                @endif
                @php
                    global $plan_day;
                    global $plan_and_day;
                    $plan_day = '';
                    $plan_and_day = '';
                    $plan_start = [];
                    $plan_end = [];
                    $todo = [];
                @endphp
                @if (!$plans[0] == '')
                    @foreach($plans as $plan)
                        @if($day == $today->day && $day == $plan->day) <!---今日と予定が一緒の時--->
                            @php
                                $plan_and_day = 'plan_and_today';
                                $plan_start[] = $plan->start;
                                $plan_end[] = $plan->end;
                                $todo[] = $plan->todo;
                            @endphp
                        @elseif($day == $today->day && $today->month == $m) <!---今日--->
                            @php $plan_day = 'today'; @endphp
                        @elseif($day == $plan->day) <!---予定--->
                            @php
                                $plan_day = 'plan_day';
                                $plan_start[] = $plan->start;
                                $plan_end[] = $plan->end;
                                $todo[] = $plan->todo;
                            @endphp
                        @endif
                    @endforeach
                @elseif($day == $today->day && $today->month == $m)
                    @php $plan_day = 'today'; @endphp
                @endif
                    @if($plan_and_day === 'plan_and_today')
                        <td scope="col" class="bg-warning">{{$day}}
                            <p class="text-danger">today</p>
                            @for($i = 0; $i < count($todo); $i++)
                                <p class="text-danger">{{$todo[$i]}}{{$plan_start[$i]}}時~{{$plan_end[$i]}}時</p>
                            @endfor
                        </td>
                    @elseif($plan_day === 'today')
                        <td scope="col" class="bg-secondary">{{$day}}<p class="text-white">today</p></td>
                    @elseif($plan_day === 'plan_day')
                        <td scope="col" class="bg-primary">{{$day}}
                            @for($i = 0; $i < count($todo); $i++)
                                <p class="text-white">{{$todo[$i]}}{{$plan_start[$i]}}時~{{$plan_end[$i]}}時</p>
                            @endfor
                        </td>
                    @else
                        <td scope="col" class="">{{$day}}</td>
                    @endif
            @endforeach
        </tr>
    </table>

    @if(isset($err))
        <p class="text-danger">{{$err}}</p>
    @endif
    <form action="/team/{{$id}}/days/todo?y={{$y}}&&m={{$m}}" method="POST">
        @csrf
        <p>
            <select name="month" id="">
                @for($i = 1;$i <= 12;$i++)
                    @if($plana->month == $i)
                        <option value="{{$i}}" selected>{{$i}}</option>
                    @else
                        <option value="{{$i}}">{{$i}}</option>
                    @endif
                @endfor
            </select>月
            <select  class="ml-1" name="day" id="">
                @for($i = 1;$i <= 31;$i++)
                    @if($plana->day == $i)
                        <option value="{{$i}}"  selected>{{$i}}</option>
                    @else
                        <option value="{{$i}}">{{$i}}</option>
                    @endif
                @endfor
            </select>日
            <select  class="ml-2" name="start" id="">
                @for($i = 0;$i <= 24;$i++)
                    @if($plana->start == $i)
                        <option value="{{$i}}" selected>{{$i}}時</option>
                    @else
                        <option value="{{$i}}">{{$i}}時</option>
                    @endif
                @endfor
            </select> ~
            <select name="end" id="">
                @for($i = 0;$i <= 24;$i++)
                    @if($plana->end == $i)
                        <option value="{{$i}}" selected>{{$i}}時</option>
                    @else
                        <option value="{{$i}}">{{$i}}時</option>
                    @endif
                @endfor
            </select>
            <input class="ml-2" type="text" name="todo" value="{{$plana->todo}}">
        </p>
        <input type="hidden" name="team_id" value="{{$plana->team_id}}">
        <input type="hidden" name="todo_id" value="{{$plana->id}}">
        <p><input class="btn pb-1 pt-1 pr-2 pl-2" type="submit" value="変更する"></p>
    </form>
    <form action="/team/{{$id}}/days/{{$plana->id}}/delete" method="POST">
        @csrf
        <p><input class="btn del pb-1 pt-1 pr-2 pl-2" type="submit" value="削除する"></p>
    </form>
    <p><a href="/team/{{$id}}/days/?y={{$y}}&&m={{$m}}">戻る</a></p>

</div>
@endsection
