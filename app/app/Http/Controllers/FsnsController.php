<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\team; //teamsモデルの参照

class FsnsController extends Controller
{
    public function index()
    {
        return view('top');
    }

    // チームページ
    public function teams()
    {
        return view('team');
    }

    //チーム編集
    public function create()
    {
        return view('create');
    }

    public function myteams(Request $request)
    {
        return view('team');
    }
    // //日程 days
    // public function days()
    // {
    //     return view('days');
    // }
}
