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

        $followers = DB::table('followers')->where('team_id', $id)->count();
        return view('team', ['item' => $items[0], 'id' => $id, 'tt' => $tt, 'followers' => $followers]);
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
        DB::table('teams')->where('id', $request->id)->update($param);
            return redirect('/teams');
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
            return view('days', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers]);
        }else{
            $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->get()->sortBy('day');
            // dd($plans);

            return view('days', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers]);
        }
        // $plans = DB::select('select * from todos WHERE team_id = ' . $items[0]->id);

    }

    // todo
    public function todo($id)
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
            return view('todo', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers]);
        }else{
            $plans = DB::table('todos')->where('month', $m)->where('team_id', $items[0]->id)->get()->sortBy('day');

            return view('todo', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers]);
        }

    }


    // 日程変更
    public function daysup($id,$todo_id)
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
            return view('daysup', ['item' => $items[0], 'id' => $id, 'plana' => $plana[0], 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'plans' => $plans, 'followers' => $followers]);

        }else{
            return view('daysup', ['item' => $items[0], 'id' => $id, 'plana' => $plana[0], 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'plans' => $plans, 'followers' => $followers]);
        }


    }

    //日程変更完了
    public function dup(Request $request, $id)
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
            return view('todo', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers]);

        } else {

            return view('todo', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers]);
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
            return view('days', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers]);

        } else {

            return view('days', ['item' => $items[0], 'id' => $id, 'plans' => $plans, 'tmY' => $tmY, 'tmM' => $tmM, 'subY' => $subY, 'subM' => $subM, 'addY' => $addY, 'addM' => $addM, 'days' => $days, 'weekFirst' => $weekFirst, 'dt' => $dt, 'today' => $today, 'tt' => $tt, 'followers' => $followers]);
        }
    }

    //予定の削除
    public function ddel($id,$todo_id)
    {
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

        return view('movie', ['item' => $items[0], 'movies' => $movies, 'tt' => $tt, 'followers' => $followers]);
    }

    //動画のアップロード
    public function upload($id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        // dd($items);
        return view('upload', ['item' => $items[0], 'tt' => $tt, 'followers' => $followers]);
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

        return view('movie', ['item' => $items[0], 'tt' => $tt, 'movies' => $movies, 'followers' => $followers]);
    }

    //movieの変更削除ページ
    public function movieup($id,$movie_id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        $movie = DB::table('movies')->where('id', $movie_id)->get();
        // dd($movie);
        return view('movieup', ['item' => $items[0], 'tt' => $tt, 'movie' => $movie[0], 'followers' => $followers]);
    }

    //movieの変更
    public function mup(Request $request,$id, $movie_id)
    {
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
        return view('movie', ['item' => $items[0], 'tt' => $tt, 'movies' => $movies, 'followers' => $followers]);
    }

    //movieの削除
    public function mdel($id, $movie_id)
    {
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
        return view('movie', ['item' => $items[0], 'tt' => $tt, 'movies' => $movies, 'followers' => $followers]);
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

        return view('blog', ['item' => $items[0], 'blogs' => $blogs, 'tt' => $tt, 'followers' => $followers]);
    }

    //ブログの変更削除
    public function blogup($id, $blog_id)
    {
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

        return view('blogup', ['item' => $items[0], 'blog' => $blog[0], 'tt' => $tt, 'followers' => $followers]);
    }

    //ブログの変更
    public function bup(Request $request, $id, $blog_id)
    {
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

        return view('blog', ['item' => $items[0], 'blogs' => $blogs, 'tt' => $tt, 'followers' => $followers]);
    }

    //投稿
    public function post($id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        return view('post', ['item' => $items[0], 'tt' => $tt, 'followers' => $followers]);
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

        $tt = My_func::today();

        $followers = DB::table('followers')->where('team_id', $id)->count();
        $blogs = Blog::all()->where('team_id', $id);
        if($blogs == null){
            $blogs = new Blog;
            $blogs->append('title', '');
            $blogs->append('blog', '');
        }

        $items = DB::select('select * from teams WHERE id = ' . $id);
        return view('blog', ['item' => $items[0], 'tt' => $tt, 'blogs' => $blogs, 'followers' => $followers]);
    }

    //ブログの削除
    public function bdel($id,$blog_id)
    {
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

        return view('blog', ['item' => $items[0], 'blogs' => $blogs, 'tt' => $tt, 'followers' => $followers]);
    }

    // コンタクト
    public function contact($id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        return view('contact', ['item' => $items[0], 'tt' => $tt, 'followers' => $followers]);
    }

    //コンタクトの送信
    public function mail(Request $request, $id)
    {
        $tt = My_func::today();

        $items = DB::select('select * from teams WHERE id = ' . $id);
        $followers = DB::table('followers')->where('team_id', $id)->count();
        return view('contact', ['item' => $items[0],'tt' => $tt, 'followers' => $followers]);
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
        $users = DB::select('select * from users WHERE id = ' . $id);
        return view('account', ['users' => $users[0]]);
    }
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
        $users = DB::select('select * from users WHERE id = ' . $id);
        return view('mypage', ['users' => $users[0]]);
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
