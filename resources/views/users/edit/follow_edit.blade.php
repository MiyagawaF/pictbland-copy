@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">フォロー受付設定</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="/users/update/follow" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            @foreach (config('user_settings') as $key => $value)   
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="user_settings" id="user_settings" value="{{$key}}" @isset ($user_setting) @if ($user_setting->follow_status == $key) checked @endif @endisset @if ($loop->first) checked @endif>
                                <label class="form-check-label" for="user_settings">{{$value}}</label>
                            </div>
                            @endforeach
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
