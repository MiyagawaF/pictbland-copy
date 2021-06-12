<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Work;
use App\Profile;
use Storage;

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
        $profile = Profile::where('user_id', $id)->first();
        return view('users/profile', ['user' => $user, 'works' => $works, 'profile' => $profile]);
    }

    /**
     * プロフィール編集画面の表示
     */
    public function profEdit(){
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        return view('/users/edit/prof_edit', ['user' => $user, 'profile' => $profile]);
    }

    public function profUpdate(Request $request){
        $request->validate([
            'name' => 'required',
            'intro' => 'max:1000'
        ]);
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->save();
        
        $profile = Profile::where('user_id', $user->id)->first();

        $profile->intro = $request->input('intro');
        if (isset($request->prof_image)) {
            $prof_image = $request->file('prof_image');
            $path = Storage::disk('s3')->putFile('profile', $prof_image, 'public');
            $profile->image_url = Storage::disk('s3')->url($path);
        }
        $profile->save();

        return redirect('/home');
    }
}
