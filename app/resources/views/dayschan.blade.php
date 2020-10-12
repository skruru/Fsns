@extends('team')

@section('show')
<?php
use Carbon\Carbon;

$dt = Carbon::now();

$m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
$y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';
if($m!=''||$y!=''){
    $dt = Carbon::createFromDate($y,$m,01);
}else{
    $dt = Carbon::createFromDate();
}

//先月
$sub = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
$subMonth = $sub->subMonth();
$subY = $subMonth->year;
$subM = $subMonth->month;

//今月
$tm = Carbon::createFromDate();
$tmY = $tm->year;
$tmM = $tm->month;

//来月
$add = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
$addMonth = $add->addMonth();
$addY = $addMonth->year;
$addM = $addMonth->month;

$title = '<caption><a href="./days?y='.$tmY.'&&m='.$tmM.'">今日</a>';
$title .= '<a href="./days?y='.$subY.'&&m='.$subM.'"><<前月 </a>';//前月のリンク
$title .= $dt->format('F Y');//月と年を表示
$title .= '<a href="./days?y='.$addY.'&&m='.$addM.'"> 来月>></a></caption>';//来月リンク

echo $title;

?>

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
        <?php
        $days = null;
        $dt->startOfMonth();
        $daysInMonth = $dt->daysInMonth;
        for($i = 1; $i <= $daysInMonth; $i++) {
            if($i == 1) {
                if ($dt->format('N')!= 7) {
                $days .= '<td colspan="'.($dt->format('N')).'"></td>';
                }
            }
            if($dt->format('N') == 7){
                $days .= '</tr><tr>';
            }

            $today = new Carbon($dt->year."-".$dt->month."-".$dt->day);
            $today_now = Carbon::today();

            if($today->eq($today_now)) {
                $days .= '<td class="bg-secondary text-white">' . $dt->day .'</td>';
            } else {

                switch ($dt->format('N')) {
                    case 6:
                        $days .= '<td scope="col" class="text-primary">' . $dt->day . '</td>';
                    break;
                    case 7:
                        $days .= '<td scope="col" class="text-danger">' . $dt->day . '</td>';
                    break;
                    default:
                    $days .= '<td scope="col" class="">' . $dt->day . '</td>';
                break;
                }
            }
            $dt->addDay();
        }
        echo $days;
        ?>
        <!-- <td scope="col" class="">1</td> -->
    </tr>
</table>

<p><a href="/team/{{$item->id}}/days/todo">予定を追加</a></p>
@yield('todo')
<p>予定を削除</p>
@for($i = 0; $i <= count($plan) - 1; $i++)
<dl class="border">
<dt>{{$plan[$i]->month}}月 {{$plan[$i]->day}}日</dt>
<dd>{{$plan[$i]->start}}時　〜　{{$plan[$i]->end}}時まで　　{{$plan[$i]->todo}}</dd>
<form action="/team/{{$item->id}}/days/dayschan" method="post">
<input type="hidden" name="{{$plan[$i]->id}}">
<input type="submit" value="変更">
</form>
</dl>
@endfor
@endsection
