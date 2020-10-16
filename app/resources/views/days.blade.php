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
        @elseif($plans[0] != '' && $day == $today->day && $day == $plans[0]->day)
        <td scope="col" class="bg-danger">{{$day}}<p class="text-white">today</p></td>
        @elseif($day == $today->day && $today->month == $tt['tmM'])
        <td scope="col" class="bg-secondary">{{$day}}<p class="text-white">today</p></td>
        @elseif($plans[0] != '' && $day == $plans[0]->day)
        <td scope="col" class="bg-primary">{{$day}}<p class="text-white">{{$plans[0]->todo}}</p></td>
        @else
        <td scope="col" class="">{{$day}}</td>
        @endif
        @endforeach
    </tr>
</table>

<p><a href="/team/{{$item->id}}/days/todo?m={{$today->month}}">予定を追加</a></p>
@yield('todo')
@if($plans[0] != '')
@foreach($plans as $plan)
<dl class="border">
<dt>{{$plan->month}}月 {{$plan->day}}日</dt>
<dd>{{$plan->start}}時　〜　{{$plan->end}}時まで　　{{$plan->todo}}</dd>
<form action="/team/{{$item->id}}/days/daysUp/{{$plan->id}}" method="get">
<p><input type="submit" value="変更・削除"></p>
</form>
</dl>
@endforeach
@endif
@endsection
