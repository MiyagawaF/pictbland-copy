@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{-- プロフィール --}}
        <div class="prof col-md-3 border p-10">
            <div class="">
                <img src="#">
            </div>
            <div class="">
                <div class="">
                    <p class="text-center">ユーザー名</p>
                </div>
                <div>
                    <p>プロフィールプロフィールプロフィールプロフィールプロフィールプロフィールプロフィールプロフィールプロフィール</p>
                </div>
                <div class="row">
                    <div class="col bg-white">
                        <p>20</p>
                        <span>投稿</span>
                    </div>
                    <div class="col bg-white">
                        <p>100</p>
                        <span>フォロー</span>
                    </div>
                </div>
            </div>
            <div>
                <div class="mt-10 mb-10">
                    <span>あなたのフォロワー</span>
                </div>
                <div class="row">
                    <div class="col"><img src="#"></div>
                    <div class="col"><img src="#"></div>
                    <div class="col"><img src="#"></div>
                    <div class="col"><img src="#"></div>
                </div>
                <div>
                    <a href="#">フォロワー一覧へ</a>
                </div>
            </div>
        </div>
        <div class="timeline col-md-8 ml-20">
            <div class="title bg-secondary border p-2">
                <span>新着作品</span>
            </div>
            <div class="border bg-light p-2 text-center">
                <span>再読み込み</span>
            </div>
            <div class="border p-3">
                <div><img src="#"></div>
                <div>
                    <p><a href="#">ユーザー名</a> 2021/04/21 15:00</p>
                    <p><a href="#">作品タイトル</a>が投稿されました</p>
                    <div class="border ml-5 mr-3 row">
                        <div class="col-md-3">
                            <img src="#" alt="サムネイル" class="">
                            <span>★</span>
                            <span>⇒</span>
                        </div>
                        <div class="col-md-8">
                            <a href="#">作品タイトル</a>
                            <p>キャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプション…</p>
                            <div>
                                <ul>
                                    <li class="p-1 bg-secondary small"><a href="#">タグ１</a></li>
                                    <li class="p-1 bg-secondary small"><a href="#">タグ２</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
