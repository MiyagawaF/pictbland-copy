<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Work;
use App\Profile;
use App\FollowUser;
use App\UserSetting;
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
        $user_setting = UserSetting::where('user_id', $id)->first();
        $status = 1;

        $auth_user = Auth::user();
        $follow_users = FollowUser::where('follow_id', $user->id)->where('follower_id', $auth_user->id)->first();
        if (isset($follow_users) && $follow_users->follow_approval == 1){
            $follow_button = "btn-danger";
            $button_txt = "フォロー解除";
            $status = 4;
        }else if ($user_setting->follow_status == 2 && empty($follow_users)) {
            $follow_button = "btn-info";
            $button_txt = "フォロー申請する";
            $status = 2;
        }else if ($user_setting->follow_status == 2 && $follow_users->follow_approval == 0) {
            $follow_button = "btn-secondary";
            $button_txt = "フォロー申請中";
            $status = 3;
        }else{
            $follow_button = "btn-info";
            $button_txt = "フォローする";
            $status = 1;
        }

        return view('users/profile', ['user' => $user, 'works' => $works, 'profile' => $profile, 'follow_button' => $follow_button, 'button_txt' => $button_txt, 'user_setting' => $user_setting,'status' => $status]);
    }

    /**
     * プロフィール編集画面の表示
     */
    public function profEdit(){
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        return view('/users/edit/prof_edit', ['user' => $user, 'profile' => $profile]);
    }

    //プロフィール編集保存
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

    /**
     * フォロー受付設定編集画面の表示
     */
    public function followEdit(){
        $user = Auth::user();
        $user_setting = UserSetting::where('user_id', $user->id)->first();
        if (empty($user_setting)) {
            return view('/users/edit/follow_edit', ['user' => $user]);
        }else{
            return view('/users/edit/follow_edit', ['user' => $user, 'user_setting' => $user_setting]);
        }
    }

    //フォロー受付設定編集保存
    public function followUpdate(Request $request){
        $user = Auth::user();
        $user_setting = UserSetting::where('user_id', $user->id)->first();
        if (empty($user_setting)) {
            $user_setting = new UserSetting();
            $user_setting->user_id = $user->id;
        }
        $user_setting->follow_status = $request->input('user_settings');
        $user_setting->save();

        return redirect('/home');
    }

    //フォロー機能
    public function follow($id){
        $status = 1;
        $user = Auth::user();
        //フォローをした相手のフォロー受付設定の呼び出し
        $user_setting = UserSetting::where('user_id', $id)->first();
        //既にフォローしているか確認
        $follow_users = FollowUser::where('follow_id', $id)->where('follower_id', $user->id)->first();
        if (isset($follow_users)) {
            //フォロー済みだったらdelete_atを追加
            $follow_users->delete();
            $follow_users->save();
            if ($user_setting->follow_status == 1) {
                $status = 1;
            }else if ($user_setting->follow_status == 2) {
                $status = 2;
            }
        }else{

            $follow_users = new FollowUser();
            //ログインしているユーザーがフォローした相手のid
            $follow_users->follow_id = $id;
            //ログインしている（フォローをした）ユーザーのid
            $follow_users->follower_id = $user->id;
            if ($user_setting->follow_status == 1) {
                //フォローを常に受け付ける設定の時
                $follow_users->follow_approval = 1;
                $follow_users->save();
                $status = 4;
            }else if ($user_setting->follow_status == 2) {
                //承認制でフォローを受け付ける設定の時
                $follow_users->follow_approval = 0;
                $follow_users->save();
                $status = 3;
            }else if ($user_setting->follow_status == 3) {
                //フォローを受付しない設定の時
                $status = 5;
            }
        }
        return $status;
    }

    //フォロー一覧
    public function follow_list(){
        $user = Auth::user();
        $follow_users = FollowUser::where('follower_id', $user->id)
        ->whereNull('deleted_at')
        ->join('users', 'follow_users.follow_id', '=', 'users.id')
        ->join('profiles', 'follow_users.follow_id', '=', 'profiles.user_id')
        ->orderBy('follow_users.created_at', 'desc')
        ->paginate(20);
        // ->get();

        return view('/users/follow_list', ['follow_users' => $follow_users]);
    }
}
