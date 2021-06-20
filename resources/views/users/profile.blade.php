@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        {{-- プロフィール --}}
        <div class="prof col-sm-3 border p-0 pt-3 bg-white">
            <div class="w-100">
                <img src="@isset($profile) {{$profile->image_url}} @else /img/profile.png @endisset" class="prof_img w-100 mx-auto d-block">
            </div>
            <div class="mt-3 pb-3 bg-secondary">
                <div class="pt-3">
                    <p class="text-center text-white">{{$user->name}}</p>
                </div>
                <div class="mr-3 ml-3 bg-white rounded p-2">
                    <p>@isset($profile) {{$profile->intro}} @else よろしくお願いします！@endisset</p>
                </div>
                <div class="row mr-3 ml-3 mt-3">
                    <div class="col bg-white mr-2">
                        <p class="text-center">20<br>
                        <span>投稿</span></p>
                    </div>
                    <div class="col bg-white">
                        <p class="text-center">100<br>
                        <span>フォロー</span></p>
                    </div>
                </div>
            </div>
            <div class="w-100">
                <button class="btn {{$follow_button}} mt-3 text-white" id="follow_button" data-follow_id="{{$user->id}}">{{$button_txt}}</button>
            </div>

        </div>
        <div class="timeline col-lg-9 ml-20">
            <div class="title bg-secondary border p-2">
                <span>投稿作品</span>
            </div>
            <div class="border bg-light p-2 text-center">
                <span>再読み込み</span>
            </div>
            @foreach ($works as $work)
            <div class="border p-3">
                <div class="row mb-2">
                    <div class="col-md-1"><img src="{{$profile->image_url}}" class="w-100"></div>
                    <div class="col-md-5">
                    <span><a href="#">{{$work->name}}</a> {{$work->created_at}}</span><br>
                        <span><a href="#">{{$work->title}}</a>が投稿されました</span>
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
                        <a href="#">{{$work->title}}</a>
                        <p>{{str_limit($work->caption, 120, '　…')}}</p>
                        <div>
                            <div class="flex-row">
                                <span class="p-1 bg-secondary small text-light">小説</span>
                                @switch($work->publish_status)
                                    @case(1)
                                        <span class="p-1 bg-secondary small text-light">{{Config::get('publish_st_tag.1')}}</span>
                                        @break
                                    @case(2)
                                        <span class="p-1 bg-secondary small text-light">{{Config::get('publish_st_tag.2')}}</span>
                                        @break
                                    @case(3)
                                        <span class="p-1 bg-secondary small text-light">{{Config::get('publish_st_tag.3')}}</span>
                                        @break
                                    @case(4)
                                        <span class="p-1 bg-secondary small text-light">{{Config::get('publish_st_tag.4')}}</span>
                                        @break
                                    @case(5)
                                        <span class="p-1 bg-secondary small text-light">{{Config::get('publish_st_tag.5')}}</span>
                                        @break
                                @endswitch
                                <span class="p-1 bg-dark small text-light">鍵付き</span>
                                {{-- <span class="p-1 bg-secondary small"><a href="#" class="text-light">タグ２</a></span> --}}
                            </div>
                            <div class="flex-row mt-1">
                                <span class="small"><a href="#">タグ１</a></span>
                                <span class="small"><a href="#">タグ２</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#follow_button').click(function() {
            // フォローしたユーザーのidを取得する
            var id = $(this).data('follow_id');

            // Ajax通信
            $.ajax({
                headers: {
                    // csrf対策
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/users/follow/' + id, // アクセスするURL
                type: 'POST', // POSTかGETか
                success: function() {
                    //通信が成功した場合の処理をここに書く
                    //フォローボタンをフォロー解除に切り替える
                    if ($("#follow_button").hasClass("btn-info")) {
                        $("#follow_button").removeClass("btn-info");
                        $("#follow_button").addClass("btn-danger");
                        $("#follow_button").text("フォロー解除");
                    }else if ($("#follow_button").hasClass("btn-danger")) {
                        $("#follow_button").removeClass("btn-danger");
                        $("#follow_button").addClass("btn-info");
                        $("#follow_button").text("フォローする");
                    }
                },
                error: function() {
                    //通信が失敗した場合の処理をここに書く
                    alert("フォローに失敗しました");
                }
            });
        });
    });
</script>
@endsection
