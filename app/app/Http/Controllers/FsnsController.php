<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;
use App\Models\Blog;
use App\Models\Movie;
// use App\Models\Todo;
use App\Lib\My_func;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class FsnsController extends Controller
{
    //--------------------------------------top---------------------------------------
    public function index()
    {
        $blogs = DB::table('blogs')->orderBy('updated_at', 'desc')->get();
        $user = Auth::user();

        if(Auth::user() == null)
        {
            $teams[] = DB::table('teams')->get();
            $user = null;

            return view('top', ['blogs' => $blogs, 'teams' => $teams, 'user' => $user]);

        } elseif ($blogs->isEmpty()){

            $teams[] = DB::table('teams')->get();

            return view('top', ['blogs' => $blogs, 'teams' => $teams, 'user' => $user]);

        } else {

            for($i = 0; $i <= count($blogs) - 1; $i++)
            {
                $team_id[] = $blogs[$i]->team_id;
            }
            for($i = 0; $i <= count($team_id) - 1; $i++)
            {
                $teams[] = DB::table('teams')->where('id', $team_id[$i])->get();
            }

            return view('top', ['blogs' => $blogs, 'teams' => $teams, 'user' => $user]);
        }
    }

    //topページのフォローチームのブログ
    public function blogs()
    {
        $user = Auth::user();
        $follows = DB::table('followers')->where('user_id', $user->id)->get();

        if($follows->isEmpty())
        {
            $blogs = null;

            return view ('topblog', ['blogs' => $blogs, 'user' => $user]);
        }

        foreach($follows as $follow)
        {
            $blog = DB::table('blogs')->orderBy('updated_at', 'desc')->where('team_id', $follow->team_id)->get();

            if($blog->isEmpty()){
                continue;
            } else {
                $blogs[] = $blog;
            }
        }

        foreach($blogs as $blog)
        {
            $team[] = DB::table('teams')->where('id', $blog[0]->team_id)->get();
        }

        return view('topblog', ['blogs' => $blogs, 'team' => $team, 'user' => $user]);
    }

    //--------------------------------------team---------------------------------------


    // 全チーム一覧
    public function teams()
    {
        session()->forget('key');

        $teams = Team::all();

        return view('teams', ['teams' => $teams]);
    }

    // チームの検索
    public function serch(Request $request)
    {
        $team = DB::table('teams')->where('team_name',$request->team_name)->count();

        if($team == 0){
            $err = '検索されたチームはありません';

            return view('serch', ['err' => $err]);
        } else {

            $team = DB::table('teams')->where('team_name',$request->team_name)->get();

            return redirect('/team/'.$team[0]->id);
        }
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

        DB::table('teams')->insert($param);
            return redirect('/teams');
    }

    // 個別チームのページ
    public function team($id)
    {
        $tt = My_func::today();

        $team = DB::select('select * from teams WHERE id = ' . $id);

        if (count($team) == 0) {
            return abort(404);
        }
        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('team', ['team' => $team[0], 'id' => $id, 'tt' => $tt, 'followers' => $followers, 'follow' => $follow]);
    }

    //teamの編集のパスワード
    public function teamlogin($id)
    {
        $session = session()->get('key');

        $team = DB::table('teams')->where('id', $id)->get();

        if($session == $team[0]->team_password)
        {
            return view('update',['id' => $id, 'team' => $team[0]]);

        }
        return view('teamlogin', ['id' => $id]);
    }

    //teamleader
    public function teamleader(Request $request,$id)
    {
        $tt = My_func::today();

        session()->put(['key' => $request->team_password]);

        $team = DB::select('select * from teams WHERE id = ' . $id);

        if (count($team) == 0) {
            return abort(404);
        }

        $followers = DB::table('followers')->where('team_id', $id)->count();

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('team', ['team' => $team[0], 'id' => $id, 'tt' => $tt, 'followers' => $followers, 'follow' => $follow]);

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


        DB::table('teams')->where('id', $id)->update($param);

        return redirect('/team/'.$id);
    }

    //チームの削除
    public function del($id)
    {
        DB::table('teams')->where('id', $id)->delete();
        return redirect('/teams');
    }

    //--------------------------teamnav------------------------------------------------

    // 日程 days
    public function days($id)
    {
        $tt = My_func::today();

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';

        $dt = Carbon::now();
        $dt->month = $m;
        $dt->year = $y;

        //今の月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        //前の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $subMonth = $tm->subMonth();
        $subY = $subMonth->year;
        $subM = $subMonth->month;

        //次の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $addMonth = $tm->addMonth();
        $addY = $addMonth->year;
        $addM = $addMonth->month;

        $daysInMonth = $dt->daysInMonth; //月の最後の日にち
        $weekFirst = $dt->format('N'); //月の初めの曜日
        $today = Carbon::today(); //今日

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

        $team = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plan = DB::table('todos')->where('team_id', $id)->where('month', $m)->get();

        if($plan->isEmpty())
        {
            $plans[] = '';
        } else {
            $plans = DB::table('todos')->where('month', $m)->where('team_id', $id)->get()->sortBy('day')->sortBy('start');
        }

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('days', ['team' => $team[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'today' => $today, 'tt' => $tt, 'followers' => $followers,'y' => $y, 'm' => $m, 'follow' => $follow]);
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

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';

        $dt = Carbon::now();
        $dt->month = $m;
        $dt->year = $y;

        //今の月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        //前の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $subMonth = $tm->subMonth();
        $subY = $subMonth->year;
        $subM = $subMonth->month;

        //次の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $addMonth = $tm->addMonth();
        $addY = $addMonth->year;
        $addM = $addMonth->month;

        $daysInMonth = $dt->daysInMonth; //月の最後の日にち
        $weekFirst = $dt->format('N'); //月の初めの曜日
        $today = Carbon::today(); //今日

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

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $team[0]->id)->get()->sortBy('day');

        if($plans->isEmpty())
        {
            $plans[] = '';
        }else{
            $plans = DB::table('todos')->where('month', $m)->where('team_id', $team[0]->id)->get()->sortBy('day')->sortBy('start');
        }

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('todo', ['team' => $team[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'today' => $today, 'tt' => $tt, 'followers' => $followers,'y' => $y, 'm' => $m, 'daysInMonth' => $daysInMonth,'follow' => $follow]);
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

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';

        $dt = Carbon::now();
        $dt->month = $m;
        $dt->year = $y;

        //今の月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        //前の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $subMonth = $tm->subMonth();
        $subY = $subMonth->year;
        $subM = $subMonth->month;

        //次の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $addMonth = $tm->addMonth();
        $addY = $addMonth->year;
        $addM = $addMonth->month;

        $daysInMonth = $dt->daysInMonth; //月の最後の日にち
        $weekFirst = $dt->format('N'); //月の初めの曜日
        $today = Carbon::today(); //今日

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

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plana = DB::table('todos')->where('id', $todo_id)->get();
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $id)->get()->sortBy('day')->sortBy('start');

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('daysup', ['team' => $team[0], 'id' => $id, 'plana' => $plana[0], 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'today' => $today, 'tt' => $tt, 'followers' => $followers,'y' => $y, 'm' => $m, 'follow' => $follow]);

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

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';

        $dt = Carbon::now();
        $dt->month = $m;
        $dt->year = $y;

        //今の月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        //前の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $subMonth = $tm->subMonth();
        $subY = $subMonth->year;
        $subM = $subMonth->month;

        //次の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $addMonth = $tm->addMonth();
        $addY = $addMonth->year;
        $addM = $addMonth->month;

        $daysInMonth = $dt->daysInMonth; //月の最後の日にち
        $weekFirst = $dt->format('N'); //月の初めの曜日
        $today = Carbon::today(); //今日

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

        $teams = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $teams[0]->id)->get()->sortBy('day');

        if($request->start > $request->end){
            $err = '始まる時間は終わる時間より早い時間で設定してください。';
            $plana = DB::table('todos')->where('id', $request->todo_id)->get();

            return view('daysup', ['team' => $team[0], 'id' => $id, 'plans' => $plans, 'plana' => $plana[0], 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'today' => $today, 'tt' => $tt, 'followers' => $followers,'y' => $y, 'm' => $m, 'daysInMonth' => $daysInMonth, 'err' => $err]);

        }elseif($request->todo == ''){

            $err = '内容を設定してください。';
            $plana = DB::table('todos')->where('id', $request->todo_id)->get();

            return view('daysup', ['team' => $team[0], 'id' => $id, 'plans' => $plans, 'plana' => $plana[0], 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'today' => $today, 'tt' => $tt, 'followers' => $followers,'y' => $y, 'm' => $m, 'daysInMonth' => $daysInMonth, 'err' => $err]);
        }

        $param = [
            'team_id' => $request->team_id,
            'month' => $request->month,
            'day' => $request->day,
            'start' => $request->start,
            'end' => $request->end,
            'todo' => $request->todo,
        ];
        DB::table('todos')->where('id', $request->todo_id)->update($param);

        $plans = DB::table('todos')->where('month', $m)->where('team_id', $teams[0]->id)->get()->sortBy('day')->sortBy('start');

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('todo', ['team' => $team[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'today' => $today, 'tt' => $tt, 'followers' => $followers,'y' => $y, 'm' => $m, 'daysInMonth' => $daysInMonth, 'follow' => $follow]);

    }

    //予定の追加
    public function add(Request $request,$id)
    {
        $tt = My_func::today();

        $m = isset($_GET['m'])? htmlspecialchars($_GET['m'], ENT_QUOTES, 'utf-8') : '';
        $y = isset($_GET['y'])? htmlspecialchars($_GET['y'], ENT_QUOTES, 'utf-8') : '';

        $dt = Carbon::now();
        $dt->month = $m;
        $dt->year = $y;

        //今の月
        $tm = Carbon::createFromDate($dt->year,$dt->month,$dt->day);
        $tmY = $tm->year;
        $tmM = $tm->month;

        //前の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $subMonth = $tm->subMonth();
        $subY = $subMonth->year;
        $subM = $subMonth->month;

        //次の月
        $tm = Carbon::createFromDate($dt->year,$dt->month);
        $addMonth = $tm->addMonth();
        $addY = $addMonth->year;
        $addM = $addMonth->month;

        $daysInMonth = $dt->daysInMonth; //月の最後の日にち
        $weekFirst = $dt->format('N'); //月の初めの曜日
        $today = Carbon::today(); //今日

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

        $team = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $plans = DB::table('todos')->where('month', $m)->where('team_id', $team[0]->id)->get()->sortBy('day');

        if($request->start > $request->end){
            $err = '始まる時間は終わる時間より早い時間で設定してください。';

            return view('todo', ['team' => $team[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'today' => $today, 'tt' => $tt, 'followers' => $followers,'y' => $y, 'm' => $m, 'daysInMonth' => $daysInMonth, 'err' => $err]);
        }elseif($request->todo == ''){

            $err = '内容を設定してください。';

            return view('todo', ['team' => $team[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'today' => $today, 'tt' => $tt, 'followers' => $followers,'y' => $y, 'm' => $m, 'daysInMonth' => $daysInMonth, 'err' => $err]);
        }

        $param = [
            'team_id' => $request->id,
            'month' => $request->month,
            'day' => $request->day,
            'start' => $request->start,
            'end' => $request->end,
            'todo' => $request->todo,
        ];
        DB::table('todos')->insert($param);

        $plans = DB::table('todos')->where('month', $m)->where('team_id', $team[0]->id)->get()->sortBy('day')->sortBy('start');

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('days', ['team' => $team[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'today' => $today, 'tt' => $tt, 'followers' => $followers,'y' => $y, 'm' => $m, 'follow' => $follow]);
    }

    //予定の削除
    public function ddel($id,$todo_id)
    {
        $today = Carbon::today(); //今日

        $teams = DB::select('select * from teams WHERE id = ' . $id);
        // dd($todo_id);
        DB::table('todos')->where('id', $todo_id)->delete();

        return redirect('/team/'.$teams[0]->id.'/days/?y='.$today->year.'&&m='.$today->month);
    }

    //動画
    public function movie($id)
    {
        $tt = My_func::today();

        $team = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movies = Movie::all()->where('team_id', $id);

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('movie', ['team' => $team[0], 'movies' => $movies,'id' => $id, 'tt' => $tt, 'followers' => $followers, 'follow' => $follow]);
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

        $followers = DB::table('followers')->where('team_id', $id)->count();

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('upload', ['team' => $team[0], 'tt' => $tt,'id' => $id , 'followers' => $followers, 'follow' => $follow]);
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

        $team = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movies = Movie::all()->where('team_id', $id);

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('movie', ['team' => $team[0], 'tt' => $tt, 'movies' => $movies,'id' => $id, 'followers' => $followers, 'follow' => $follow]);
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

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movie = DB::table('movies')->where('id', $movie_id)->get();

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('movieup', ['team' => $team[0], 'tt' => $tt, 'movie' => $movie[0],'id' => $id, 'followers' => $followers, 'follow' => $follow]);
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

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movies = Movie::all()->where('team_id', $id);

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('movie', ['team' => $team[0], 'tt' => $tt, 'movies' => $movies,'id' => $id, 'followers' => $followers, 'follow' => $follow]);
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

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movies = Movie::all()->where('team_id', $id);

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('movie', ['team' => $team[0], 'tt' => $tt, 'movies' => $movies,'id' => $id, 'followers' => $followers, 'follow' => $follow]);
    }

    // ブログ
    public function blog($id)
    {
        $tt = My_func::today();

        $team = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $blogs = Blog::all()->where('team_id', $id);

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('blog', ['team' => $team[0], 'blogs' => $blogs, 'tt' => $tt,'id' => $id, 'followers' => $followers, 'follow' => $follow]);
    }

    //投稿画面
    public function post($id)
    {
        $session = session()->get('key');
        $team = DB::table('teams')->where('id', $id)->get();

        if($session != $team[0]->team_password)
        {
            return view('teamlogin', ['id' => $id]);
        }

        $tt = My_func::today();

        $followers = DB::table('followers')->where('team_id', $id)->count();

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('post', ['team' => $team[0], 'tt' => $tt,'id' => $id, 'followers' => $followers, 'follow' => $follow]);
    }

    //投稿
    public function show(Request $request, $id)
    {
        $param = [
            'team_id' => $request->team_id,
            'title' => $request->title,
            'text' => $request->text,
        ];
        DB::table('blogs')->insert($param);

        $tt = My_func::today();

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $blogs = Blog::all()->where('team_id', $id);
        $team = DB::select('select * from teams WHERE id = ' . $id);

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('blog', ['team' => $team[0], 'tt' => $tt,'id' => $id, 'blogs' => $blogs, 'followers' => $followers, 'follow' => $follow]);
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

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $blog = DB::table('blogs')->where('team_id', $id)->where('id', $blog_id)->get();

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('blogup', ['team' => $team[0], 'blog' => $blog[0], 'tt' => $tt, 'id' => $id, 'followers' => $followers, 'follow' => $follow]);
    }

    //ブログの変更
    public function bup(Request $request, $id, $blog_id)
    {
        $tt = My_func::today();

        $param = [
            'team_id' => $request->team_id,
            'title' => $request->title,
            'text' => $request->text,
        ];
        DB::table('blogs')->where('team_id', $id)->where('id',$blog_id)->update($param);

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $blogs = Blog::all()->where('team_id', $id);
        $team = DB::table('teams')->where('id', $id)->get();

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('blog', ['team' => $team[0], 'blogs' => $blogs, 'tt' => $tt,'id' => $id, 'followers' => $followers, 'follow' => $follow]);
    }

    //ブログの削除
    public function bdel($id,$blog_id)
    {
        $tt = My_func::today();

        $team = DB::select('select * from teams WHERE id = ' . $id);

        DB::table('blogs')->where('team_id', $id)->where('id',$blog_id)->delete();

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $blogs = Blog::all()->where('team_id', $id);

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('blog', ['team' => $team[0], 'blogs' => $blogs, 'tt' => $tt,'id' => $id, 'followers' => $followers, 'follow' => $follow]);
    }

    // コンタクト
    public function contact($id)
    {
        $tt = My_func::today();

        $team = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('contact', ['team' => $team[0], 'tt' => $tt, 'followers' => $followers,'id' => $id, 'follow' => $follow]);
    }

    //コンタクトの送信
    public function mail(Request $request, $id)
    {
        $tt = My_func::today();

        $team = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();
        $follow = count($follower);

        $followers = DB::table('followers')->where('team_id', $id)->count();

        return view('contact', ['team' => $team[0],'tt' => $tt, 'followers' => $followers,'id' => $id, 'follow' => $follow]);
    }

    //フォロワーページ
    public function follower($id)
    {
        $tt = My_func::today();

        $team = DB::select('select * from teams WHERE id = ' . $id);

        $followers = DB::table('followers')->where('team_id', $id)->orderBy('user_id', 'desc')->get();

        if($followers->isEmpty())
        {
            $user[0] = null;

            return view('follower', ['team' => $team[0], 'tt' => $tt, 'id' => $id, 'user' => $user[0]]);

        }

        $user = DB::table('users')->where('id', $followers[0]->user_id)->get();

        return view('follower', ['team' => $team[0], 'tt' => $tt, 'id' => $id, 'user' => $user[0]]);
    }

    //teamのフォロー
    public function tfollow(Request $request,$id)
    {
        $tt = My_func::today();

        $user = Auth::user();
        $user_id = $user->id;

        $follower = DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->get();

        if(count($follower) == 1)
        {
            DB::table('followers')->where('team_id', $id)->where('user_id', $user_id)->delete();
            return view('follower', ['tt' => $tt, 'id' => $id, 'user' => $user[0]]);
        }

        $param = [
            'team_id' => $request->team_id,
            'user_id' => $user_id,
        ];
        DB::table('followers')->insert($param);

        $followers = DB::table('followers')->where('team_id', $id)->orderBy('user_id', 'desc')->get();
        $user = DB::table('users')->where('id', $followers[0]->user_id)->get();

        return view('follower', ['tt' => $tt, 'id' => $id, 'user' => $user[0]]);
    }

    //--------------------------------------myPage---------------------------------------

    //マイページ
    public function mypage($id)
    {
        $user = DB::select('select * from users WHERE id = ' . $id);
        $follow = DB::table('followers')->where('user_id', $id)->count();
        $current_user = Auth::user()->id;

        return view('mypage', ['user' => $user[0], 'follow' => $follow, 'current_user' => $current_user, 'id' => $id]);
    }

    //マイページ編集
    public function account(Request $request,$id)
    {
        $current_user = Auth::user();

        $page_user = $id;

        $user = DB::select('select * from users WHERE id = ' . $id);
        if($current_user->id == $page_user)
        {
            return view('account', ['user' => $user[0]]);
        } else {
            $follow = DB::table('followers')->where('user_id', $id)->count();

            return view('mypage', ['user' => $user[0], 'follow' => $follow]);
        }
    }

    //マイページ編集完了のpost
    public function rewrite(Request $request,$id)
    {
        $current_user = Auth::user()->id;

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
        $follow = DB::table('followers')->where('user_id', $id)->count();
        $user = DB::select('select * from users WHERE id = ' . $id);

        return view('mypage', ['user' => $user[0], 'follow' => $follow, 'id' => $id, 'current_user' => $current_user]);
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
            $teams[] = DB::table('teams')->where('id', $follow->team_id)->get();
        }

        return view('followteams', ['id' => $id, 'teams' => $teams[0]]);
    }
}
