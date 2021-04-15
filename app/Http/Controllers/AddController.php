<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkController extends Controller
{

    /**
     * 小説の追加ページの表示
     */
    public function detail()
    {
        return view('add/novel');
    }
}
