@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="/works/store/novel" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">タイトル</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="caption">キャプション</label>
                            <textarea class="form-control"  name="caption" id="caption" cols="30" rows="10"></textarea>
                        </div>
                        <div>
                            @foreach (config('publish_status') as $key => $value)   
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="publish_status" id="publish_status" value="{{$key}}" @if ($loop->first) checked @endif>
                                <label class="form-check-label" for="publish_status">{{$value}}</label>
                            </div>
                            @endforeach
                        </div>

                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="age_status" id="age_status" value="1" checked>
                                <label class="form-check-label" for="age_status">全年齢</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="age_status" id="age_status2" value="2">
                                <label class="form-check-label" for="age_status2">R18閲覧制限</label>
                            </div>
                        </div>

                        <input type="submit" value="作品を投稿" class="btn btn-primary mb-4">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
