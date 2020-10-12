@extends('team')

@section('show')
<caption><a href="/team/{{$item->id}}/days/?y={{$today->year}}&&m={{$today->month}}">今日</a><a href="/team/2/days?y={{$subY}}&&m={{$subM}}">前月</a>{{$tmM}}月 {{$tmY}}年<a href="/team/2/days?y={{$addY}}&&m={{$addM}}"> 来月>></a></caption>
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
        <?php if($day === null){
            echo '</tr><tr>';
        }else{
            echo '<td scope="col" class="">'.$day.'</td>';
        }
        ?>
        @endforeach
    </tr>
</table>

<p><a href="/team/{{$item->id}}/days/todo?m={{$today->month}}">予定を追加</a></p>
@yield('todo')
<p>予定を削除</p>
@for($i = 0; $i <= count($plan) - 1; $i++)
<dl class="border">
<dt>{{$plan[$i]->month}}月 {{$plan[$i]->day}}日</dt>
<dd>{{$plan[$i]->start}}時　〜　{{$plan[$i]->end}}時まで　　{{$plan[$i]->todo}}</dd>
<form action="/team/{{$item->id}}/days/daysUp/{$i}" method="get">
<p><input type="submit" value="変更"></p>
</form>
</dl>
@endfor
@endsection
