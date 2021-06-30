<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Work;
use App\WorkTag;
use App\Profile;
use App\FollowUser;

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
        $works = Work::select('users.id as user_id', 'works.id as work_id', 'users.name', 'profiles.image_url', 'works.created_at', 'works.type', 'works.title', 'works.caption', 'works.publish_status', 'works.age_status', 'works.thumbnail')
            ->join('users', 'works.user_id', '=', 'users.id')
            ->join('profiles', 'works.user_id', '=', 'profiles.user_id')
            ->orderBy('works.created_at', 'desc')
            ->get();
        foreach($works as $work) {
            $work->tags = WorkTag::where('work_id', '=', $work->work_id)->get();
        }
        $profile = Profile::where('user_id', $user->id)->first();
        $follow_users = FollowUser::where('follower_id', $user->id)->count();
        
        return view('home', ['works' => $works, 'user' => $user, 'profile' => $profile, 'follow_users' => $follow_users]);
    }

    public function readme(){
        return view('readme');
    }
}
