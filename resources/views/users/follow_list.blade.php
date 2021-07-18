@extends('layouts.app')

@section('content')
<div class="container">
    <div class="title bg-secondary text-white border p-2 w-75 m-auto">
        <span>フォローしているユーザー一覧</span>
    </div>
    <div class="w-75 m-auto row">
        @foreach ($follow_users as $follow_user)
        <div class="col-sm-6 border p-3">
            <div class="row">
                <div class="col-md-3">
                    @isset ($follow_user->img_url)
                        <img src="{{$follow_user->img_url}}" alt="プロフィール画像" class="w-100">
                    @else
                        <img src="/img/profile.png" alt="プロフィール画像" class="w-100">
                    @endisset
                    {{-- <div class="text-center mt-2">
                        <span class="border p-1">♥</span>
                        <span class="border p-1">★</span>
                    </div> --}}
                </div>
                <div class="col-md-9">
                    <a href="profile/{{$follow_user->follow_id}}">{{$follow_user->name}}</a>
                    <p>{{str_limit($follow_user->intro, 120, '　…')}}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{$follow_users->links()}}
</div>
@endsection