<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Work;
use App\WorkTag;

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
        $user = Auth::user();
        $works = Work::select('users.id as user_id', 'works.id as work_id', 'users.name', 'works.created_at', 'works.title', 'works.caption', 'works.publish_status', 'works.age_status')
            ->join('users', 'works.user_id', '=', 'users.id')
            ->orderBy('works.created_at', 'desc')
            ->get();
        foreach($works as $work) {
            $work->tags = WorkTag::where('work_id', '=', $work->work_id)->get();
        }
        return view('home', ['works' => $works, 'user' => $user]);
    }

    public function readme(){
        return view('readme');
    }
}
