<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Work;
use App\Profile;

class UserController extends Controller
{

    /**
     * プロフィールページの表示
     */
    public function profile($id)
    {
        $user = User::where('id', $id)->first();
        $works = Work::join('users', 'works.user_id', '=', 'users.id')
            ->where('user_id', $id)
            ->orderBy('works.created_at', 'desc')
            ->get();
        return view('users/profile', ['user' => $user, 'works' => $works]);
    }

    public function profEdit(){
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        return view('/users/edit/prof_edit', ['user' => $user, 'profile' => $profile]);
    }

    public function profUpdate(Request $request){
        $request->validate([
            'name' => 'required',
        ]);
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();
        $profile = Profile::find($id);
        if (isset($profile)) {
            $profile->intro = $request->input('intro');
            $profile->save();
        }

        return redirect('/home');
    }

    /**
     * 小説の投稿
     */
    // public function storeNovel(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required',
    //         'caption' => 'max:1000',
    //     ]);
    //     $work = new Work();
    //     $work->user_id = Auth::id();
    //     $work->type = 2;
    //     $work->title = $request->input('title');
    //     $work->caption = $request->input('caption');
    //     $work->publish_status = $request->input('publish_status');
    //     $work->age_status = $request->input('age_status');
    //     $work->save();
    //     return view('works/add/end');
    // }

    /**
     * 作品詳細ページの表示
     */
    // public function detail()
    // {
    //     return view('works/detail');
    // }
}
