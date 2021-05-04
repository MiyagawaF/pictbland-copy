@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{-- プロフィール --}}
        <div class="prof col-lg-3 border pt-3">
            <div class="">
                <img src="/img/profile.png" class="">
            </div>
            <div class="mt-2">
                <div class="">
                    <p class="text-center">ユーザー名</p>
                </div>
                <div>
                    <a href="../../users/profile/{{$work->user_id}}">作品一覧を見る</a>
                </div>
            </div>
        </div>

        <div class="timeline col-lg-9 ml-20 border bg-white">
            <div class="mt-3">
                <span>投稿日：{{$work->created_at}}</span>
                <h3>{{$work->title}}</h3>
            </div>
            <div>
                <button type="button" class="btn btn-outline-primary">&#9829;<br>いいね！</button>
                <button type="button" class="btn btn-outline-primary">&#9733;<br>ブクマ</button>
            </div>
            <div class="mt-3">
                <p class="caption">{{$work->caption}}</p>
            </div>

            <div class="border-top pt-3 pb-3 pr-2 pl-2">
                <div class="bg-light p-5">
                    <p class="novel_work">{{$novel_work->content}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
