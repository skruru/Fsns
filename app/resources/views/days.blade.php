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
                        <td scope="col" class="bg-danger">{{$day}}
                            <p class="text-white">today</p>
                            @for($i = 0; $i < count($todo); $i++)
                                <p class="text-white">{{$todo[$i]}}{{$plan_start[$i]}}時~{{$plan_end[$i]}}時</p>
                            @endfor
                        </td>
                    @elseif($plan_day === 'today')
                        <td scope="col" class="bg-secondary">{{$day}}<p class="text-white">today</p></td>
                    @elseif($plan_day === 'plan_day')
                        <td scope="col" class="bg-primary">{{$day}}
                            @for($i = 0; $i < count($todo); $i++)
                                <p class="text-white">{{$todo[$i]}}{{$plan_start[$i]}}~{{$plan_end[$i]}}</p>
                            @endfor
                        </td>
                    @else
                        <td scope="col" class="">{{$day}}</td>
                    @endif
            @endforeach
        </tr>
    </table>

    <p><a href="/team/{{$id}}/days/todo?y={{$y}}&&m={{$m}}">予定を追加</a></p>
    @yield('todo')
    @if($plans[0] != '')
        @foreach($plans as $plan)
            <dl class="border">
                <dt>{{$plan->month}}月 {{$plan->day}}日</dt>
                <dd>{{$plan->start}}時　〜　{{$plan->end}}時まで　　{{$plan->todo}}</dd>
                <p><a href="/team/{{$id}}/days/daysUp/{{$plan->id}}/?y={{$y}}&&m={{$m}}">変更・削除</a></p>
            </dl>
        @endforeach
    @endif

</div>
@endsection
