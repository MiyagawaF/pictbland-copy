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

                @isset($work->password)
                    <div id="input_password" class="mb-3">
                        <p>{{$work->password_text}}</p>
                        <p class="d-none text-danger small" id="password_wrong">パスワードが違います</p>
                        <input type="text" id="password">
                        <input type="submit" id="submit_password">
                    </div>
                @endisset

                @if ($work->type == 2)
                    <div class="p-5 novel_content">
                        <p class="novel_work" id="content">@empty($work->password) {{$novel_work->content}} @endempty</p>
                    </div>

                @elseif ($work->type == 1)
                    
                    <div id="illust" class="p-5">
                        <div class="illust_work1 d-none">
                            <img src="@empty($work->password) {{$illust_work1->image_url}} @endempty" alt="{{$work->title}}" class="w-100">
                        </div>
                        @isset($illust_work2)
                        <div class="pt-5 illust_work2 d-none">
                            <img src="@empty($work->password) {{$illust_work2->image_url}} @endempty" alt="{{$work->title}}" class="w-100">
                        </div>
                        @endisset
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#submit_password').click(function() {
            // 入力されたパスワードが一致したら作品のコンテンツを返す
            var password = $('#password').val();
            var work_id = {{$work->id}};

            // Ajax通信
            $.ajax({
                headers: {
                    // csrf対策
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/works/password_check', // アクセスするURL
                type: 'POST', // POSTかGETか
                data: {
                    password: password,
                    work_id: work_id
                },
                success: function(res) {
                    var status = res.status;
                    if (status == 1) {
                        console.log("パスが正しいです");
                        $('#input_password').hide();
                        switch ({{$work->type}}) {
                            case 1:
                                $('.illust_work1').removeClass('d-none');
                                $('.illust_work1').children('img').attr('src', res.illust_work1.image_url);
                                if (res.illust_work2.image_url != null) {
                                    $('.illust_work2').removeClass('d-none');
                                    $('.illust_work2').children('img').attr('src', res.illust_work2.image_url);
                                }
                                break;
                            case 2:
                                $('.novel_content').addClass('bg-light');
                                $('#content').text(res.novel_work.content);
                                break;
                        }
                    }
                    else if (status == 0){
                        console.log("パスが違います", res.status);
                        $('#password_wrong').removeClass('d-none');
                    }
                },
                error: function() {
                    //通信が失敗した場合の処理をここに書く
                    console.log("失敗しました");
                    console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
                    console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
                    console.log("errorThrown    : " + errorThrown.message); // 例外情報
                    console.log("URL            : " + url);
                }
            });
        });
    });
</script>
@endsection
