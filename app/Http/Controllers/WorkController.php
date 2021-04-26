<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Work;

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
        ]);
        $work = new Work();
        $work->user_id = Auth::id();
        $work->type = 2;
        $work->title = $request->input('title');
        $work->caption = $request->input('caption');
        $work->publish_status = $request->input('publish_status');
        $work->age_status = $request->input('age_status');
        $work->save();
        return view('works/add/end');
        // return redirect('/home');
    }

    /**
     * 作品詳細ページの表示
     */
    public function detail()
    {
        return view('works/detail');
    }
}
