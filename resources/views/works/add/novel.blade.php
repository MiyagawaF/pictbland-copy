@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">小説作品の投稿</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="/works/store/novel" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">タイトル*</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="content">本文*</label>
                            <textarea class="form-control"  name="content" id="content" cols="20" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tag">タグ*</label>
                            <input type="text" class="form-control" name="tag" id="tag">
                        </div>
                        <div class="form-group">
                            <label for="caption">キャプション</label>
                            <textarea class="form-control"  name="caption" id="caption" cols="20" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="password">パスワード</label>
                            <input type="text" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password_text">パスワードの説明</label>
                            <textarea class="form-control"  name="password_text" id="password_text" cols="20" rows="3"></textarea>
                        </div>
                        <h6 class="pt-2 border-bottom">公開範囲の設定</h6>
                        <div>
                            @foreach (config('publish_status') as $key => $value)   
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="publish_status" id="publish_status" value="{{$key}}" @if ($loop->first) checked @endif>
                                <label class="form-check-label" for="publish_status">{{$value}}</label>
                            </div>
                            @endforeach
                        </div>
                        <h6 class="pt-4 border-bottom">閲覧制限の設定</h6>
                        <div class="mb-4">
                            @foreach (config('age_status') as $key => $value)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="age_status" id="age_status" value="{{$key}}" @if ($loop->first) checked @endif>
                                <label class="form-check-label" for="age_status">{{$value}}</label>
                            </div>
                            @endforeach
                        </div>

                        <input type="submit" value="作品を投稿" class="btn btn-primary mb-4">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <script>
    function hoge (e) {
  const key = e.keyCode || e.charCode || 0;
  if (key == 13) {
    e.preventDefault();
    alert('hogeeeeee');
  }
}
</script> --}}
@endsection
