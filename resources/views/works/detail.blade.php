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
                    <p class="text-center">{{$user->name}}</p>
                </div>
                <div>
                    <a href="../../users/profile/{{$work->user_id}}">作品一覧を見る</a>
                </div>
            </div>
        </div>
        
        {{-- 作品表示欄 --}}
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

            @if (!$is_opened)
                <div class="border bg-light pb-0 p-3 mt-2 mb-4">
                    @switch($work->publish_status)
                        @case(2)
                            {{-- 会員限定 --}}
                            <h4>会員限定公開作品です</h4>
                            @break
                        @case(3)
                            {{-- フォロワー限定 --}}
                            <h4>フォロワー限定公開作品です</h4>
                            @break
                        @case(4)
                            {{-- 相互フォロワー限定 --}}
                            <h4>相互フォロワー限定公開作品です</h4>
                            @break
                        @case(5)
                            {{-- 非公開 --}}
                            <h4>この作品は非公開です</h4>
                            @break
                        @default
                            @break
                    @endswitch
                </div>
            @endif
            
            {{-- 本文or画像 --}}
            @if ($is_opened)
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
                    <div class="p-5 novel_content @empty($work->password) bg-light @endempty">
                        <p class="novel_work" id="content">@empty($work->password) {{$novel_work->content}} @endempty</p>
                    </div>

                @elseif ($work->type == 1)
                    
                    <div id="illust" class="p-5">
                        <div class="illust_work1">
                            @empty($work->password)<img src="{{$illust_work1->image_url}}" alt="{{$work->title}}" class="w-100">@endempty
                        </div>
                        @isset($illust_work2)
                        <div class="mt-5 illust_work2">
                            @empty($work->password)<img src="{{$illust_work2->image_url}}" alt="{{$work->title}}" class="w-100">@endempty
                        </div>
                        @endisset
                    </div>
                @endif
            </div>
            @endif

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
                                $('.illust_work1').append('<img src="' + res.illust_work1.image_url + '" alt="{{$work->title}}-1" class="w-100">');
                                if (res.illust_work2.image_url != null) {
                                    $('.illust_work2').removeClass('d-none');
                                    $('.illust_work2').append('<img src="' + res.illust_work2.image_url + '" alt="{{$work->title}}-2" class="w-100">');
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
