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
        $work_tags = WorkTag::get();
        $works = Work::join('users', 'works.user_id', '=', 'users.id')
            ->join('work_tags', 'works.id', '=', 'work_tags.work_id')
            ->orderBy('works.created_at', 'desc')
            ->get();

        return view('home', ['works' => $works, 'user' => $user, 'work_tags' => $work_tags]);
    }
}
