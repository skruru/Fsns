<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;
use App\Models\Blog;
use App\Models\Movie;
use App\Models\Todo;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class FsnsController extends Controller
{
    public function index()
    {
        return view('top');
    }

    // チームページ
    // public function teams($id)
    // {
    //     $items = DB::select('select * from team');
    //     // dd($items);
    //     return view('team', ['items' => $items]);
    // }

    // public function team($id)
    // {
    //     return view('team');
    // }

    // 個別チームのページ
    public function team($id)
    {
        $dt = Carbon::now();

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';
        if($m!=''||$y!=''){
            $dt = Carbon::createFromDate($y,$m,01);
        }else{
        $dt = Carbon::createFromDate();
        }

        //今月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        $items = DB::select('select * from teams WHERE id = ' . $id);
        // dd($items);
        if (count($items) == 0) {
            return abort(404);
        }
        return view('team', ['item' => $items[0], 'id' => $id, 'tmY' => $tmY, 'tmM' => $tmM]);
    }

    // 全チーム一覧
    public function teams(Request $request)
    {
        // $teams = DB::select('select * from teams');
        // dd(count($teams));
        $teams = Team::all();
        return view('teams', ['teams' => $teams]);
    }

    //チーム作成
    public function create()
    {
        return view('create');
    }

    //チームのcreateページのpost送信
    public function edit(Request $request)
    {
        $param = [
            'team_name' => $request->team_name,
            'team_area' => $request->team_area,
            'team_img' => $request->team_img,
            'team_password' => $request->team_password,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'mail' => $request->mail,
            'team_contents' => $request->team_contents,
        ];
        // $id =  DB::table('teams')->insertGetId($param);
            // return redirect('/team/'.$id);
        DB::table('teams')->insert($param);
            return redirect('/teams');
    }

    // チーム編集
    public function change (Request $request, $id)
    {
        $items = DB::select('select * from teams WHERE id = ' . $id);
        // dd($items);
        return view('update',['item' => $items[0]]);
    }

    public function update (Request $request, $id)
    {
        $param = [
            'team_name' => $request->team_name,
            'team_area' => $request->team_area,
            'team_img' => $request->team_img,
            'team_password' => $request->team_password,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
            'mail' => $request->mail,
            'team_contents' => $request->team_contents,
        ];
        DB::table('teams')->where('id', $request->id)->update($param);
            return redirect('/teams');
    }

    //チームの検索
    // public function serch(Request $request)
    // {
    //     return
    // }

    // 日程 days
    public function days($id)
    {
        $dt = Carbon::now();

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';
        if($m!=''||$y!=''){
            $dt = Carbon::createFromDate($y,$m,01);
        }else{
        $dt = Carbon::createFromDate();
        }

        //今月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        //先月
        $subMonth = $tm->subMonth();
        $subY = $subMonth->year;
        $subM = $subMonth->month;

        //来月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $addMonth = $tm->addMonth();
        $addY = $addMonth->year;
        $addM = $addMonth->month;

        $days = null;
        $daysFirst = $dt->startOfMonth(); //月の最初の日にち

        $daysInMonth = $dt->daysInMonth; //月の最後の日にち
        $weekFirst = $dt->format('N'); //月の初めの曜日

        $today = Carbon::today(); //今日
        // dd($today_now);
        $days = [];

        if($weekFirst != 7) {
            for($i = 1;$i <= $weekFirst;$i++){
                $days[] = '';
            }
        }

        for($i = 1; $i <= $daysInMonth; $i++) {
            if($weekFirst == 7 && $i != 1){
                $days[] = null;
                $weekFirst = 0;
            }elseif($weekFirst == 7 && $i == 1){
                $weekFirst = 0;
            }
            $days[] = $i;
            $weekFirst++;
        }
        // dd($days);

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->orderBy(
            'day'
        )->get();
        // dd($m);

        // $plans = DB::select('select * from todos WHERE team_id = ' . $items[0]->id);
        return view('days', ['item' => $items[0], 'id' => $id, 'plan' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today]);

    }

    // todo
    public function todo($id)
    {
        $dt = Carbon::now();

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';
        if($m!=''||$y!=''){
            $dt = Carbon::createFromDate($y,$m,01);
        }else{
        $dt = Carbon::createFromDate();
        }

        //今月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        //先月
        $subMonth = $tm->subMonth();
        $subY = $subMonth->year;
        $subM = $subMonth->month;

        //来月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $addMonth = $tm->addMonth();
        $addY = $addMonth->year;
        $addM = $addMonth->month;

        $days = null;
        $daysFirst = $dt->startOfMonth(); //月の最初の日にち

        $daysInMonth = $dt->daysInMonth; //月の最後の日にち
        $weekFirst = $dt->format('N'); //月の初めの曜日

        $today = Carbon::today(); //今日
        // dd($today_now);
        $days = [];

        if($weekFirst != 7) {
            for($i = 1;$i <= $weekFirst;$i++){
                $days[] = '';
            }
        }

        for($i = 1; $i <= $daysInMonth; $i++) {
            if($weekFirst == 7 && $i != 1){
                $days[] = null;
                $weekFirst = 0;
            }elseif($weekFirst == 7 && $i == 1){
                $weekFirst = 0;
            }
            $days[] = $i;
            $weekFirst++;
        }
        $items = DB::select('select * from teams WHERE id = ' . $id);
        // dd($m);
        // $plans = DB::select('select * from todos WHERE team_id = ' . $items[0]->id);
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->orderBy(
            'day'
        )->get();

        // dd($plans);

        return view('todo', ['item' => $items[0], 'id' => $id, 'plan' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'plans' => $plans, 'today' => $today]);
    }


    // 日程変更
    public function dayschan(Request $request, $id)
    {
        $items = DB::select('select * from teams WHERE id = ' . $id);
        $plans = DB::select('select * from todos WHERE team_id = ' . $items[0]->id);
        return view('dayschan', ['item' => $items[0]], ['plan' => $plans]);
    }

    //予定の追加
    public function add(Request $request,$id)
    {
        $param = [
            'team_id' => $request->id,
            'month' => $request->month,
            'day' => $request->day,
            'start' => $request->start,
            'end' => $request->end,
            'todo' => $request->todo,
        ];
        DB::table('todos')->insert($param);

        $dt = Carbon::now();

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';
        if($m!=''||$y!=''){
            $dt = Carbon::createFromDate($y,$m,01);
        }else{
        $dt = Carbon::createFromDate();
        }

        //今月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        //先月
        $subMonth = $tm->subMonth();
        $subY = $subMonth->year;
        $subM = $subMonth->month;

        //来月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $addMonth = $tm->addMonth();
        $addY = $addMonth->year;
        $addM = $addMonth->month;

        $days = null;
        $daysFirst = $dt->startOfMonth(); //月の最初の日にち

        $daysInMonth = $dt->daysInMonth; //月の最後の日にち
        $weekFirst = $dt->format('N'); //月の初めの曜日

        $today = Carbon::today(); //今日
        // dd($today_now);
        $days = [];

        if($weekFirst != 7) {
            for($i = 1;$i <= $weekFirst;$i++){
                $days[] = '';
            }
        }

        for($i = 1; $i <= $daysInMonth; $i++) {
            if($weekFirst == 7 && $i != 1){
                $days[] = null;
                $weekFirst = 0;
            }elseif($weekFirst == 7 && $i == 1){
                $weekFirst = 0;
            }
            $days[] = $i;
            $weekFirst++;
        }
        // dd($days);

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->orderBy(
            'day'
        )->get();

        return view('days', ['item' => $items[0], 'id' => $id, 'plan' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today]);
    }

    //動画
    public function movie($id)
    {
        $items = DB::select('select * from teams WHERE id = ' . $id);
        $movies = Movie::where('team_id', $id)->first();
        return view('movie', ['item' => $items[0]], ['movies' => $movies]);
    }

    //動画のアップロード
    public function upload($id)
    {
        $items = DB::select('select * from teams WHERE id = ' . $id);
        dd($items);
        return view('upload', ['item' => $items[0]]);
    }

    //データベースへのアップロード
    public function up(Request $request,$id)
    {
        $param = [
            'team_id' => $request->team_id,
            'title' => $request->title,
            'movie' => $request->movie,
        ];
        DB::table('movies')->insert($param);
        $items = DB::select('select * from teams WHERE id = ' . $id);
        return view('movie', ['item' => $items[0]]);
    }

    // ブログ
    public function blog($id)
    {
        $items = DB::select('select * from teams WHERE id = ' . $id);
        $blogs = Blog::where('team_id', $id)->first();
        return view('blog', ['item' => $items[0]], ['blogs' => $blogs]);
    }

    //投稿
    public function post($id)
    {
        $items = DB::select('select * from teams WHERE id = ' . $id);
        return view('post', ['item' => $items[0]]);
    }

    //表示
    public function show(Request $request, $id)
    {
        $param = [
            'team_id' => $request->team_id,
            'title' => $request->title,
            'text' => $request->text,
        ];
        DB::table('blogs')->insert($param);
        $items = DB::select('select * from teams WHERE id = ' . $id);
        return view('blog', ['item' => $items[0]]);
    }

    // コンタクト
    public function contact($id)
    {
        $items = DB::select('select * from teams WHERE id = ' . $id);
        return view('contact', ['item' => $items[0]]);
    }

    //コンタクトの送信
    public function mail(Request $request, $id)
    {
        $items = DB::select('select * from teams WHERE id = ' . $id);
        return view('contact', ['item' => $items[0]]);
    }

    //マイページ
    public function mypage($id)
    {
        $users = DB::select('select * from users WHERE id = ' . $id);
        return view('mypage', ['users' => $users[0]]);
    }

    //マイページ編集
    public function account()
    {
        return view('account');
    }

    //playersのページ
    public function players()
    {
        $players = User::all();
        return view('players',['players' => $players]);
    }

    //playerの新規作成ページ
    public function player()
    {
        return view('player');
    }

    //playerのuser登録
    public function user(Request $request)
    {
        $param = [
            'name' => $request->account_name,
            'area' => $request->account_area,
            'email' => $request->account_mail,
            'gender' => $request->gender,
            'experience' => $request->experience,
            'password' => $request->account_password,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'facebook' => $request->facebook,
        ];
        DB::table('users')->insert($param);
            return redirect('/players');
    }
}
