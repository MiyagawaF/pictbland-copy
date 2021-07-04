<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Work;
use App\NovelWork;
use App\IllustWork;
use App\WorkTag;
use App\User;
use App\FollowUser;
use Storage;

class WorkController extends Controller
{

    /**
     * 小説の追加ページの表示
     */
    public function addNovel()
    {
        return view('/works/add/novel');
    }

    /**
     * 小説の投稿
     */
    public function storeNovel(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'caption' => 'max:1000',
            'content' => 'required',
            'tag' => 'required'
        ]);
        $work = new Work();
        $work->user_id = Auth::id();
        $work->type = 2;
        $work->title = $request->input('title');
        $work->caption = $request->input('caption');
        $work->publish_status = $request->input('publish_status');
        $work->age_status = $request->input('age_status');
        $work->password = $request->input('password');
        $work->password_text = $request->input('password_text');
        if (isset($request->thumbnail)){
            $thumbnail = $request->file('thumbnail');
            $path = Storage::disk('s3')->putFile('illust', $thumbnail, 'public');
            $work->thumbnail = Storage::disk('s3')->url($path);
        }
        $work->save();

        $novel_work = new NovelWork();
        $novel_work->work_id = $work->id;
        $novel_work->content = $request->input('content');
        $novel_work->save();

        $work_tags = new WorkTag();
        $work_tags->work_id = $work->id;
        $work_tags->tag = $request->input('tag');
        $work_tags->save();

        return redirect('/works/add/end');
        //return redirect('/home');
    }

    public function addIllust()
    {
        return view('/works/add/illust');
    }

    /**
     * イラストの投稿
     */
    public function storeIllust(Request $request){
        $request->validate([
            'title' => 'required',
            'caption' => 'max:1000',
            'image1' => 'required',
            'tag' => 'required'
        ]);
        $work = new Work();
        $work->user_id = Auth::id();
        $work->type = 1;
        $work->title = $request->input('title');
        $work->caption = $request->input('caption');
        $work->publish_status = $request->input('publish_status');
        $work->age_status = $request->input('age_status');
        $work->password = $request->input('password');
        $work->password_text = $request->input('password_text');
        $work->save();

        $work_tags = new WorkTag();
        $work_tags->work_id = $work->id;
        $work_tags->tag = $request->input('tag');
        $work_tags->save();

        //１枚目の画像
        $illust_work = new IllustWork();
        $illust_work->work_id = $work->id;
        $image1 = $request->file('image1');
        $path = Storage::disk('s3')->putFile('illust', $image1, 'public');
        $illust_work->image_url = Storage::disk('s3')->url($path);
        $illust_work->page = 1;
        $illust_work->save();
        //サムネイル投稿
        $work->thumbnail = $illust_work->image_url;
        $work->save();

        //２枚目の画像
        $image2 = $request->file('image2');
        //dd($image2);
        if (isset($image2)) {
            $illust_work = new IllustWork();
            $illust_work->work_id = $work->id;
            $path = Storage::disk('s3')->putFile('illust', $image2, 'public');
            $illust_work->image_url = Storage::disk('s3')->url($path);
            $illust_work->page = 2;
            //dd($image_url);
            // $illust_work->image_url = Storage::disk('s3')->url($path);
            $illust_work->save();
        }

        //dd($illust_work);
        return redirect('/works/add/end');
    }

    public function addEnd(){
        return view('works/add/end');
    }

    /**
     * 作品詳細ページの表示
     */
    public function detail($id)
    {
        $work = Work::where('id', $id)->first();

        $novel_work = Novelwork::where('work_id', $id)->first();
        $illust_work1 = IllustWork::where('work_id', $id)->where('page', 1)->first();
        $illust_work2 = IllustWork::where('work_id', $id)->where('page', 2)->first();
        //作品を投稿したユーザー
        $user = User::where('id', $work->user_id)->first();
        $is_opened = true;

        //1 全体公開の場合
        if ($work->publish_status == 1) {
            return view('works/detail', [
                'work' => $work,
                'novel_work' => $novel_work,
                'illust_work1' => $illust_work1,
                'illust_work2' => $illust_work2,
                'user' => $user,
                'is_opened' => $is_opened
            ]);
        }

        //2 会員限定の場合
        $auth_user = Auth::user();
        if (empty($auth_user)) {
            $is_opened = false;
            return view('works/detail', [
                'work' => $work,
                'user' => $user,
                'is_opened' => $is_opened
            ]);
        }

        //作品を投稿したユーザーをログインユーザーがフォローしているか
        $user_followed = FollowUser::where('follow_id', $user->id)->where('follower_id', $auth_user->id)->first();
        //ログインユーザーを作品を投稿したユーザーがフォローしているか
        $auth_user_followed = FollowUser::where('follow_id', $auth_user->id)->where('follower_id', $user->id)->first();

        //3 フォロワー限定公開
        if ($work->publish_status == 3) {
            if (empty($user_followed)) {
                $is_opened = false;
            }
        }

        //4 相互フォロワー限定公開
        if ($work->publish_status == 4) {
            if (empty($user_followed) || empty($auth_user_followed)) {
                $is_opened = false;
            }
        }

        //5 非公開
        if ($work->publish_status == 5) {
            if ($work->user_id != $auth_user->id) {
                $is_opened = false;
            }
        }

        //閲覧できる条件が揃っていたら作品の内容を渡す
        if ($is_opened) {
            return view('works/detail', [
                'work' => $work,
                'novel_work' => $novel_work,
                'illust_work1' => $illust_work1,
                'illust_work2' => $illust_work2,
                'user' => $user,
                'is_opened' => $is_opened
            ]);
        }else{
            return view('works/detail', [
                'work' => $work,
                'user' => $user,
                'is_opened' => $is_opened
            ]);
        }

        //publish_statusが会員限定or全体公開の場合
        // if ($work->publish_status == 1 || $work->publish_status == 2) {

        //     $work_pub_st = "opened";
        // }else{
        //     $work_pub_st = "closed";
        // }

        // //公開範囲とフォロー関係の条件が合っているか否かの判断
        
        // //作品を投稿したユーザーをログインユーザーがフォローしているか
        // $user_followed = FollowUser::where('follow_id', $user->id)->where('follower_id', $auth_user->id)->first();
        // //ログインユーザーを作品を投稿したユーザーがフォローしているか
        // $auth_user_followed = FollowUser::where('follow_id', $auth_user->id)->where('follower_id', $user->id)->first();
        
        // //公開範囲3 フォロー限定時の判定
        // if ($work->publish_status == 3) {
        //     if(isset($user_followed)) {
        //         $pub_st_judge = 1;//条件を満たして閲覧可能
        //     }else{
        //         $pub_st_judge = 0;//条件を満たしていないので閲覧不可
        //     }
        // }
        // //公開範囲4 相互フォロー限定時の判定
        // if ($work->publish_status == 4) {
        //     if(isset($user_followed) && isset($auth_user_followed)) {
        //         $pub_st_judge = 1;//条件を満たして閲覧可能
        //     }else{
        //         $pub_st_judge = 0;//条件を満たしていないので閲覧不可
        //     }
        // }
        

        // //パスなしかつ公開範囲が会員限定以下、または公開の条件を満たす場合
        // if (empty($work->password) && ($work_pub_st == "opened" || $pub_st_judge == 1)) {
        //     $novel_work = Novelwork::where('work_id', $id)->first();
        //     $illust_work1 = IllustWork::where('work_id', $id)->where('page', 1)->first();
        //     $illust_work2 = IllustWork::where('work_id', $id)->where('page', 2)->first();
        // }
        // //dd($illust_work1);
        // return view('works/detail', ['work' => $work, 'novel_work' => $novel_work, 'illust_work1' => $illust_work1, 'illust_work2' => $illust_work2, 'user' => $user, 'work_pub_st' => $work_pub_st, 'pub_st_judge' => $pub_st_judge]);
    }

    //パスワード付き作品の表示
    public function password_check(Request $request)
    {
        $password = $request->password;
        $work_id = $request->work_id;

        $work = Work::where('id', $work_id)->first();
        if ($work->password != $password) {
            $status = 0;
            return response()->json(['status' => $status]);
        }
        
        $status = 1;
        //dd($status);
        if ($work->type == 1) {
            $illust_work1 = IllustWork::where('work_id', $work_id)->where('page', 1)->first();
            $illust_work2 = IllustWork::where('work_id', $work_id)->where('page', 2)->first();

            return response()->json(['illust_work1' => $illust_work1, 'illust_work2' => $illust_work2, 'status' => $status]);
        }else if ($work->type == 2) {
            $novel_work = NovelWork::where('work_id', $work_id)->first();

            return response()->json(['novel_work' => $novel_work, 'status' => $status]);
        }
    }

    /**
     * 作品管理ページの表示
     */
    public function index()
    {
        $user = Auth::user();
        $works = Work::where('user_id', $user->id)->get();
        return view('works/index', ['works' => $works]);
    }

    /**
     * 小説編集ページの表示
     */
    public function editNovel($id)
    {
        $work = Work::where('id', $id)->first();
        $novel_work = NovelWork::where('work_id', $id)->first();
        $work_tag = WorkTag::where('work_id', $id)->first();
        return view('works/edit/novel', ['work' => $work, 'novel_work' => $novel_work, 'work_tag' => $work_tag]);
    }

    /**
     * 小説編集内容保存
     */
    public function updateNovel(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'caption' => 'max:1000',
            'content' => 'required',
            'tag' => 'required'
        ]);
        $work = Work::find($id);
        $work->title = $request->title;
        $work->caption = $request->caption;
        $work->publish_status = $request->publish_status;
        $work->age_status = $request->age_status;
        $work->password = $request->password;
        $work->password_text = $request->password_text;
        $work->save();

        $novel_work = NovelWork::where('work_id', $id)->first();
        $novel_work->content = $request->content;
        $novel_work->save();

        $work_tag = WorkTag::where('work_id', $id)->first();
        $work_tag->tag = $request->tag;
        $work_tag->save();

        return redirect('works/index');
    }

    /**
     * イラスト編集ページの表示
     */
    public function editIllust($id)
    {
        $work = Work::where('id', $id)->first();
        $work_tag = WorkTag::where('work_id', $id)->first();
        $illust_work1 = IllustWork::where('work_id', $id)->where('page', 1)->first();
        $illust_work2 = IllustWork::where('work_id', $id)->where('page', 2)->first();
        return view('works/edit/illust', ['work' => $work, 'illust_work1' => $illust_work1, 'illust_work2' => $illust_work2, 'work_tag' => $work_tag]);
    }

    /**
     * イラスト編集内容保存
     */
    public function updateIllust(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'caption' => 'max:1000',
            'tag' => 'required'
        ]);
        $work = Work::find($id);
        $work->title = $request->title;
        $work->caption = $request->caption;
        $work->publish_status = $request->publish_status;
        $work->age_status = $request->age_status;
        $work->password = $request->password;
        $work->password_text = $request->password_text;
        $work->save();

        $work_tag = WorkTag::where('work_id', $id)->first();
        $work_tag->tag = $request->tag;
        $work_tag->save();

        //dd($request->image1_r);
        //dd($image1_r);
        //１枚目の画像
        //$image1_r = $request->file('image1_r');
        if (isset($request->image1_r)) {
            $image1_r = $request->file('image1_r');
            $illust_work1 = IllustWork::where('work_id', $id)->where('page', 1)->first();
            $path = Storage::disk('s3')->putFile('illust', $image1_r, 'public');
            $illust_work1->image_url = Storage::disk('s3')->url($path);
            $illust_work1->save();
        }

        //２枚目の画像
        //$image2_r = $request->file('image2_r');
        if (isset($request->image2_r)) {
            $image2_r = $request->file('image2_r');
            $illust_work2 = IllustWork::where('work_id', $id)->where('page', 2)->first();
            $path = Storage::disk('s3')->putFile('illust', $image2_r, 'public');
            $illust_work2->image_url = Storage::disk('s3')->url($path);
            $illust_work2->save();
        }

        return redirect('works/index');
    }

    public function search(Request $request) {
        $keyword = $request->search;
        $search_method = $request->search_method;
        $order = $request->order;
        if (!isset($order)) {
            //デフォルトで新着順にする
            $order = "new";
        }
        $sort = $request->sort;
        if (!isset($sort)) {
            //デフォルトで全て表示
            $sort = "all";
        }

        $work_query = Work::query();
        if ($search_method == "keyword_search") {
            //キーワード検索
            if (isset($keyword)) {
                $work_query->where('title', 'like', "%$keyword%");
                $work_query->orWhere('caption', 'like', "%$keyword%");
            }
        } else if ($search_method == "tag_search") {
            //タグ検索
            $tag_query = WorkTag::query();
            if (isset($keyword)) {
                $tag_query->where('tag', '=', "$keyword");
            }
            $work_tags = $tag_query->get();
            $work_id_array = [];
            foreach ($work_tags as $work_tag) {
                $work_id_array[] = $work_tag->work_id;
            }
            $work_query->whereIn('id', $work_id_array);
        }

        //絞り込み
        if ($sort == "illust") {
            $work_query->where('type', '=', '1');
        } else if ($sort == "novel") {
            $work_query->where('type', '=', '2');
        }

        //並び替え
        if ($order == "old") {
            $work_query->orderBy('works.created_at', 'asc');
        } else if ($order == "new") {
            $work_query->orderBy('works.created_at', 'desc');
        }

        $works = $work_query->paginate(20);
        //dd($works);

        return view('works/search', ['works' => $works, 'keyword' => $keyword, 'search_method' => $search_method, 'order' => $order, 'sort' => $sort]);
    }
}
