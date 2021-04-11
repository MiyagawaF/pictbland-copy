<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkController extends Controller
{

    /**
     * 作品詳細ページの表示
     */
    public function detail()
    {
        return view('work/detail');
    }
}
