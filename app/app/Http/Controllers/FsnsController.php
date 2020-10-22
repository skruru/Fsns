<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;
use App\Models\Blog;
use App\Models\Movie;
use App\Models\Todo;
use App\Lib\My_func;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use App\Http\Controllers\Auth;


class FsnsController extends Controller
{
    public function index()
    {
        $blogs = DB::table('blogs')->orderBy('updated_at', 'desc')->get();
        // dd($blogs);
        if($blogs->isEmpty())
        {
            $teams[] = DB::table('teams')->get();

            return view('top', ['blogs' => $blogs, 'teams' => $teams]);

        } else {
            for($i = 0; $i <= count($blogs)-1; $i++)
            {
                $team_id[] = $blogs[$i]->team_id;
            }
            for($i = 0; $i <= count($team_id) -1; $i++)
            {
                $teams[] = DB::table('teams')->where('id', $team_id[$i])->get();
            }
            // dd($teams[2][0]);
            return view('top', ['blogs' => $blogs, 'teams' => $teams]);
        }
    }

    //topページのフォローチームのブログ
    public function blogs()
    {
        $user = Auth::user();
        $follows = DB::table('followers')->where('user_id', $user->id)->get();
        if($follows->isEmpty())
        {
            // $blogs = DB::table('blogs')->orderBy('updated_at', 'desc')->get();

            // for($i = 0; $i <= count($blogs)-1; $i++)
            // {
            //     $team_id[] = $blogs[$i]->team_id;
            // }
            // for($i = 0; $i <= count($team_id) -1; $i++)
            // {
            //     $teams[] = DB::table('teams')->where('id', $team_id[$i])->get();
            // }
            $blogs = null;

            return view ('topblog', ['blogs' => $blogs]);
        }
        foreach($follows as $follow)
        {
            $blog = DB::table('blogs')->orderBy('updated_at', 'desc')->where('team_id', $follow->team_id)->get();
            if($blog->isEmpty()){
                continue;
            }else{
                $blogs[] = $blog;
            }
        }
        // dd($blogs);
        foreach($blogs as $blog)
        {
            $team[] = DB::table('teams')->where('id', $blog[0]->team_id)->get();
        }
        // dd($team);
        return view('topblog', ['blogs' => $blogs, 'team' => $team]);
    }

    // 個別チームのページ
    public function team($id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        // dd($items);
        if (count($items) == 0) {
            return abort(404);
        }
        $err = null;

        $followers = DB::table('followers')->where('team_id', $id)->count();
        return view('team', ['item' => $items[0], 'id' => $id, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    //teamの編集のパスワード
    public function teamlogin($id)
    {
        $session = session()->get('key');
        // dd($session);
        $team = DB::table('teams')->where('id', $id)->get();
        // dd($team[0]->team_password);
        if($session == $team[0]->team_password)
        {
            $items = DB::select('select * from teams WHERE id = ' . $id);

            return view('update',['item' => $items[0]]);

        }
        return view('teamlogin', ['id' => $id]);
    }

    //teamleader
    public function teamleader(Request $request,$id)
    {
        $tt = My_func::today();

        session()->put(['key' => $request->team_password]);
        // $session = session()->get('key');

        // dd($session);

        $items = DB::select('select * from teams WHERE id = ' . $id);
        // dd($items);
        if (count($items) == 0) {
            return abort(404);
        }
        $err = null;

        $followers = DB::table('followers')->where('team_id', $id)->count();
        return view('team', ['item' => $items[0], 'id' => $id, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    // 全チーム一覧
    public function teams(Request $request)
    {
        session()->forget('key');
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
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $password = $request->team_password;
        $team = DB::table('teams')->where('id', $id)->get();
        // dd($team[0]->team_password);
        if($password != $team[0]->team_password)
        {
            $err = 'passwordが違います';
            return view('team', ['item' => $items[0], 'id' => $id, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
        }
        // dd($items);
        return view('update',['item' => $items[0]]);
    }

    //チームの削除
    public function del($id)
    {
        DB::table('teams')->where('id', $id)->delete();
        return redirect('/teams');
    }

    //チームのupdate
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
        // dd($id);
        DB::table('teams')->where('id', $request->id)->update($param);
            return redirect('/team/'.$id);
    }

    // チームの検索
    public function serch(Request $request)
    {
        $team = DB::table('teams')->where('team_name',$request->team_name)->count();
        if($team == 0){
            return redirect('/teams');
        } else {
            $team = DB::table('teams')->where('team_name',$request->team_name)->get();
            return redirect('/team/'.$team[0]->id);
        }
    }

    // 日程 days
    public function days($id)
    {
        $tt = My_func::today();

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
        // dd($today->day);
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
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plan = DB::table('todos')->where('team_id', $id)->where('month', $m)->get();

        // dd($plan);
        if($plan->isEmpty())
        {
            $plans[] = '';
            // dd($plans);
            $err = null;
            return view('days', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
        }else{
            $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->get()->sortBy('day');
            // dd($plans);
            $err = null;

            return view('days', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
        }
        // $plans = DB::select('select * from todos WHERE team_id = ' . $items[0]->id);

    }

    // todo
    public function todo($id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

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
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->get()->sortBy('day');

        // dd($plans);

        if($plans->isEmpty())
        {
            $plans[] = '';
            // dd($plans);
            $err = null;

            return view('todo', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
        }else{
            $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->get()->sortBy('day');

            $err = null;

            return view('todo', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
        }

    }


    // 日程変更
    public function daysup($id,$todo_id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

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
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plana = DB::table('todos')->where('id', $todo_id)->get();
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $id)->get()->sortBy('day');

        // dd($plans);

        if($plans->isEmpty())
        {
            $plans[] = '';

            $err = null;

            return view('daysup', ['item' => $items[0], 'id' => $id, 'plana' => $plana[0], 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'plans' => $plans, 'followers' => $followers, 'err' => $err]);

        }else{

            $err = null;

            return view('daysup', ['item' => $items[0], 'id' => $id, 'plana' => $plana[0], 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'plans' => $plans, 'followers' => $followers, 'err' => $err]);
        }


    }

    //日程変更完了
    public function dup(Request $request, $id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

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
        $param = [
            'team_id' => $request->team_id,
            'month' => $request->month,
            'day' => $request->day,
            'start' => $request->start,
            'end' => $request->end,
            'todo' => $request->todo,
        ];
        $abc = DB::table('todos')->where('id', $request->todo_id)->update($param);

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->get()->sortBy('day');
        // dd($plans);

        // $plans = DB::select('select * from todos WHERE team_id = ' . $items[0]->id);
        if($plans->isEmpty())
        {
            $plans[] = '';

            $err = null;

            return view('todo', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);

        } else {
            $err = null;

            return view('todo', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
        }

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

        $tt = My_func::today();

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
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->get()->sortBy('day');

        if($plans->isEmpty())
        {
            $plans[] = '';

            $err = null;

            return view('days', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);

        } else {

            $err = null;

            return view('days', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
        }
    }

    //予定の削除
    public function ddel($id,$todo_id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $today = Carbon::today(); //今日

        $items = DB::select('select * from teams WHERE id = ' . $id);
        // dd($todo_id);
        DB::table('todos')->where('id', $todo_id)->delete();

        return redirect('/team/'.$items[0]->id.'/days/?y='.$today->year.'&&m='.$today->month);
    }

    //動画
    public function movie($id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movies = Movie::all()->where('team_id', $id);
        if($movies == null){
            $movies = new Movie;
            $movies->append('title', '');
            $movies->append('movie', '');
        }
        // dd($tm);
        $err = null;

        return view('movie', ['item' => $items[0], 'movies' => $movies, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    //動画のアップロード
    public function upload($id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        // dd($items);
        $err = null;

        return view('upload', ['item' => $items[0], 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
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

        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movies = Movie::all()->where('team_id', $id);
        if($movies == null){
            $movies = new Movie;
            $movies->append('title', '');
            $movies->append('movie', '');
        }

        $err = null;

        return view('movie', ['item' => $items[0], 'tt' => $tt, 'movies' => $movies, 'followers' => $followers, 'err' => $err]);
    }

    //movieの変更削除ページ
    public function movieup($id,$movie_id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movie = DB::table('movies')->where('id', $movie_id)->get();
        // dd($movie);
        $err = null;

        return view('movieup', ['item' => $items[0], 'tt' => $tt, 'movie' => $movie[0], 'followers' => $followers, 'err' => $err]);
    }

    //movieの変更
    public function mup(Request $request,$id, $movie_id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

        $param = [
            'team_id' => $request->team_id,
            'title' => $request->title,
            'movie' => $request->movie,
        ];
        DB::table('movies')->where('id', $movie_id)->update($param);

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movies = Movie::all()->where('team_id', $id);
        // dd($movies);
        if($movies == null){
            $movies = new Movie;
            $movies->append('title', '');
            $movies->append('movie', '');
        }

        // dd($movie[0]);
        $err = null;

        return view('movie', ['item' => $items[0], 'tt' => $tt, 'movies' => $movies, 'followers' => $followers, 'err' => $err]);
    }

    //movieの削除
    public function mdel($id, $movie_id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

        DB::table('movies')->where('id', $movie_id)->delete();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movies = Movie::all()->where('team_id', $id);
        if($movies == null){
            $movies = new Movie;
            $movies->append('title', '');
            $movies->append('movie', '');
        }
        // dd($movie);
        $err = null;

        return view('movie', ['item' => $items[0], 'tt' => $tt, 'movies' => $movies, 'followers' => $followers, 'err' => $err]);
    }

    // ブログ
    public function blog($id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $blogs = Blog::all()->where('team_id', $id);
        if($blogs == null){
            $blogs = new Blog;
            $blogs->append('title', '');
            $blogs->append('blog', '');
        }

        $err = null;

        return view('blog', ['item' => $items[0], 'blogs' => $blogs, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    //ブログの変更削除
    public function blogup($id, $blog_id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $blog = DB::table('blogs')->where('team_id', $id)->where('id', $blog_id)->get();
        // dd($blog);
        if($blog[0] == null){
            $blog = new Blog;
            $blog->append('title', '');
            $blog->append('blog', '');
        }

        $err = null;

        return view('blogup', ['item' => $items[0], 'blog' => $blog[0], 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    //ブログの変更
    public function bup(Request $request, $id, $blog_id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $param = [
            'team_id' => $request->team_id,
            'title' => $request->title,
            'text' => $request->text,
        ];
        // dd($id);
        DB::table('blogs')->where('team_id', $id)->where('id',$blog_id)->update($param);

        $blogs = Blog::all()->where('team_id', $id);
        if($blogs == null){
            $blogs = new Blog;
            $blogs->append('title', '');
            $blogs->append('blog', '');
        }

        $err = null;

        return view('blog', ['item' => $items[0], 'blogs' => $blogs, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    //投稿
    public function post($id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $err = null;

        return view('post', ['item' => $items[0], 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    //表示
    public function show(Request $request, $id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $param = [
            'team_id' => $request->team_id,
            'title' => $request->title,
            'text' => $request->text,
        ];
        DB::table('blogs')->insert($param);

        $tt = My_func::today();

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $blogs = Blog::all()->where('team_id', $id);
        if($blogs == null){
            $blogs = new Blog;
            $blogs->append('title', '');
            $blogs->append('blog', '');
        }

        $items = DB::select('select * from teams WHERE id = ' . $id);

        $err = null;

        return view('blog', ['item' => $items[0], 'tt' => $tt, 'blogs' => $blogs, 'followers' => $followers, 'err' => $err]);
    }

    //ブログの削除
    public function bdel($id,$blog_id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);

        DB::table('blogs')->where('team_id', $id)->where('id',$blog_id)->delete();

        $followers = DB::table('followers')->where('team_id', $id)->count();

        $blogs = Blog::all()->where('team_id', $id);
        if($blogs == null){
            $blogs = new Blog;
            $blogs->append('title', '');
            $blogs->append('blog', '');
        }

        $err = null;

        return view('blog', ['item' => $items[0], 'blogs' => $blogs, 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    // コンタクト
    public function contact($id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $err = null;

        return view('contact', ['item' => $items[0], 'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    //コンタクトの送信
    public function mail(Request $request, $id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $err = null;

        return view('contact', ['item' => $items[0],'tt' => $tt, 'followers' => $followers, 'err' => $err]);
    }

    //フォロワーページ
    public function follower($id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);

        $followers = DB::table('followers')->where('team_id', $id)->orderBy('user_id', 'desc')->get();
        // dd($followers->isEmpty());
        if($followers->isEmpty())
        {

            $followers = DB::table('followers')->where('team_id', $id)->count();
            return view('team', ['item' => $items[0], 'id' => $id, 'tt' => $tt, 'followers' => $followers]);
        }
        $user = DB::table('users')->where('id', $followers[0]->user_id)->get();
        // dd($user);

        return view('follower', ['item' => $items[0], 'tt' => $tt, 'id' => $id, 'user' => $user[0]]);
    }

    //teamのフォロー
    public function tfollow(Request $request,$id)
    {
        $tt = My_func::today();

        $user = Auth::user();
        // dd($user->id);
        $user_id = $user->id;

        $param = [
            'team_id' => $request->team_id,
            'user_id' => $user_id,
        ];
        DB::table('followers')->insert($param);

        $items = DB::select('select * from teams WHERE id = ' . $id);

        $followers = DB::table('followers')->where('team_id', $id)->orderBy('user_id', 'desc')->get();
        $user = DB::table('users')->where('id', $followers[0]->user_id)->get();

        return view('follower', ['item' => $items[0], 'tt' => $tt, 'id' => $id, 'user' => $user[0]]);
    }

    //マイページ
    public function mypage($id)
    {
        $users = DB::select('select * from users WHERE id = ' . $id);
        $follow = DB::table('followers')->where('user_id', $id)->get();
        // dd(count($follow));
        $follows = count($follow);
        return view('mypage', ['users' => $users[0], 'follows' => $follows]);
    }

    //マイページ編集
    public function account(Request $request,$id)
    {
        $current_user = Auth::user();

        $user = $id;
        // $sesdata = $request->session();
        // dd($user);

        $users = DB::select('select * from users WHERE id = ' . $id);

        if($current_user->id == $user)
        {
            return view('account', ['users' => $users[0]]);
        } else {
            $follow = DB::table('followers')->where('user_id', $id)->get();
            $follows = count($follow);
            return view('mypage', ['users' => $users[0], 'follows' => $follows]);
        }
    }

    //マイページ編集完了のpost
    public function rewrite(Request $request,$id)
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
        DB::table('users')->where('id',$id)->update($param);
        $follow = DB::table('followers')->where('user_id', $id)->get();
        $follows = count($follow);
        $users = DB::select('select * from users WHERE id = ' . $id);
        return view('mypage', ['users' => $users[0], 'follows' => $follows]);
    }

    //フォローチームの一覧
    public function followteams($id)
    {
        $follows = DB::table('followers')->where('user_id', $id)->get();
        if($follows->isEmpty())
        {
            $teams = null;
            return view('followteams', ['id' => $id, 'teams' => $teams]);
        }
        foreach($follows as $follow)
        {
            $teams[] = DB::table('teams')->where('id',$follow->id)->get();
        }
        // dd($teams);
        return view('followteams', ['id' => $id, 'teams' => $teams]);
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
