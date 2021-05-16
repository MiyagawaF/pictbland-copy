<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Work;
use App\NovelWork;
use App\IllustWork;
use App\WorkTag;
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
        //dd($image_url);
        // $illust_work->image_url = Storage::disk('s3')->url($path);
        $illust_work->save();

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
        return view('works/detail', ['work' => $work, 'novel_work' => $novel_work, 'illust_work1' => $illust_work1, 'illust_work2' => $illust_work2]);
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
}
