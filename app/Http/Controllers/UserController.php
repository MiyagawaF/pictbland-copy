<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Work;
use App\Profile;
use App\FollowUser;
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

        $auth_user = Auth::user();
        $follow_users = FollowUser::where('follow_id', $user->id)->where('follower_id', $auth_user->id)->orderBy('created_at')->first();
        if (isset($follow_users) && $follow_users->deleted_at == NULL){
            $follow_button = "btn-danger";
            $button_txt = "フォロー解除";
        }else{
            $follow_button = "btn-info";
            $button_txt = "フォローする";
        }

        return view('users/profile', ['user' => $user, 'works' => $works, 'profile' => $profile, 'follow_button' => $follow_button, 'button_txt' => $button_txt]);
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

    public function follow($id){
        $user = Auth::user();
        $follow_users = FollowUser::where('follow_id', $id)->where('follower_id', $user->id)->first();
        if (isset($follow_users)) {
            $follow_users->delete();
        }else{
            $follow_users = new FollowUser();
            //ログインしているユーザーがフォローした相手のid
            $follow_users->follow_id = $id;
            //ログインしている（フォローをした）ユーザーのid
            $follow_users->follower_id = $user->id;
            $follow_users->save();
        }
    }
}
