@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">作品情報の編集</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="/works/update/illust/{{$work->id}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">タイトル*</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{$work->title}}">
                        </div>
                        {{-- <div class="form-group">
                            <label for="content">本文*</label>
                            <textarea class="form-control"  name="content" id="content" value="{{$novel_work->content}}" cols="20" rows="10">{{$novel_work->content}}</textarea>
                        </div> --}}
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <div class="w-75 h-120px">
                                    <img src="{{$illust_work1->image_url}}" alt="イラスト作品１" class="mw-100 mh-100">
                                </div>
                                <label for="image1_r" class="px_12">画像1を再選択</label>
                                <input type="file" name="image1_r" class="form-control border-0 px_12" class="">
                            </div>
                            @isset ($illust_work2)
                            <div class="form-group col-sm-5">
                                <div class="w-75 h-120px">
                                    <img src="{{$illust_work2->image_url}}" alt="イラスト作品２" class="mw-100 mh-100">
                                </div>
                                <label for="image2_r" class="px_12">画像2を再選択</label>
                                <input type="file" name="image2_r" class="form-control border-0 px_12" class="">
                            </div>
                            @endisset
                        </div>
                        <div class="form-group">
                            <label for="tag">タグ*</label>
                            <input type="text" class="form-control" name="tag" id="tag" value="{{$work_tag->tag}}">
                        </div>
                        <div class="form-group">
                            <label for="caption">キャプション</label>
                            <textarea class="form-control"  name="caption" id="caption" value="{{$work->caption}}"cols="20" rows="5">{{$work->caption}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="password">パスワード</label>
                            <input type="text" class="form-control" name="password" id="password" value="{{$work->password}}">
                        </div>
                        <div class="form-group">
                            <label for="password_text">パスワードの説明</label>
                            <textarea class="form-control"  name="password_text" id="password_text" cols="20" rows="3">{{$work->password_text}}</textarea>
                        </div>
                        <h6 class="pt-2 border-bottom">公開範囲の設定</h6>
                        <div>
                            @foreach (config('publish_status') as $key => $value)   
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="publish_status" id="publish_status" value="{{$key}}" @if ($work->publish_status == $key) checked @endif>
                                <label class="form-check-label" for="publish_status">{{$value}}</label>
                            </div>
                            @endforeach
                        </div>
                        <h6 class="pt-4 border-bottom">閲覧制限の設定</h6>
                        <div class="mb-4">
                            @foreach (config('age_status') as $key => $value)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="age_status" id="age_status" value="{{$key}}" @if ($work->age_status == $key) checked @endif>
                                <label class="form-check-label" for="age_status">{{$value}}</label>
                            </div>
                            @endforeach
                        </div>

                        <input type="submit" value="編集を保存する" class="btn btn-primary mb-4">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
