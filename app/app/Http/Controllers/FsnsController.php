<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    // //日程 days
    // public function days()
    // {
    //     return view('days');
    // }
}
