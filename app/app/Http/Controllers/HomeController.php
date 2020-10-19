<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
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
}
