@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">プロフィールの編集</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="/users/update/prof" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">ユーザー名</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <div class="w-25">
                                @isset ($profile->image_url)
                                    <img src="{{$profile->image_url}}" alt="プロフィール画像" class="mw-100">
                                @else
                                    <img src="/img/profile.png" alt="プロフィール画像" class="mw-100">
                                @endisset
                                <p class="px_12">現在のプロフィール画像</p>
                            </div>
                            <label for="prof_image" class="px_12">プロフィール画像を選択</label>
                            <input type="file" name="prof_image" class="form-control border-0 px_12" class="">
                            <p class="text-danger px_12">※180×180pxの画像推奨</p>
                        </div>
                        <div class="form-group">
                            <label for="intro">プロフィール</label>
                            <textarea class="form-control" name="intro" id="intro" cols="20" rows="10">@isset ($profile) {{$profile->intro}} @else プロフィールを入力 @endisset</textarea>
                        </div>

                        <input type="submit" value="設定を保存" class="btn btn-primary mb-4">

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
