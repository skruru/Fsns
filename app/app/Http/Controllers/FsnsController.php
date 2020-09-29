<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\team; //teamsモデルの参照
use Illuminate\Support\Facades\DB;

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
    public function team($id)
    {
        $items = DB::select('select * from teams WHERE id = ' . $id);
        // dd($items);
        if (count($items) == 0) {
            return abort(404);
        }
        return view('team', ['item' => $items[0]]);
    }
    public function teams(Request $request)
    {
        // $teams = DB::select('select * from teams');
        // dd(count($teams));
        $teams = Team::all();
        return view('teams', ['teams' => $teams]);
    }

    //チーム編集
    public function create()
    {
        return view('create');
    }

    //チームのcreateページのpost送信
    public function edit(Request $request)
    {
        $param = [
            'team_id' => $request->team_id,
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

    // チーム編集update
    public function update (Request $request)
    {
        return view('/update');
    }
    // //日程 days
    // public function days()
    // {
    //     return view('days');
    // }
}
