@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{-- プロフィール --}}
        <div class="prof col-lg-3 border pt-3">
            <div class="">
                <img src="/img/profile.png" class="">
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
        <div class="timeline col-lg-9 ml-20">
            <div class="title bg-secondary border p-2">
                <span>新着作品</span>
            </div>
            <div class="border bg-light p-2 text-center">
                <span>再読み込み</span>
            </div>
            <div class="border p-3">
                <div>
                    <div class="row">
                        <div class="col-md-1"><img src="/img/profile.png" class="w-100"></div>
                        <div class="col-md-5">
                            <p><a href="#">ユーザー名</a> 2021/04/21 15:00</p>
                            <p><a href="#">作品タイトル</a>が投稿されました</p>
                        </div>
                    </div>
                    <div class="border ml-5 mr-3 row p-2">
                        <div class="col-md-2">
                            <img src="/img/worksample.jpg" alt="サムネイル" class="w-100">
                            <div class="text-center mt-2">
                                <span class="border p-1">★</span>
                                <span class="border p-1">⇒</span>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <a href="#">作品タイトル</a>
                            <p>キャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプションキャプション…</p>
                            <div>
                                <div class="flex-row">
                                    <span class="p-1 bg-secondary small"><a href="#" class="text-light">タグ１</a></span>
                                    <span class="p-1 bg-secondary small"><a href="#" class="text-light">タグ２</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
