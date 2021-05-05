@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">作品の管理</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="d-inline-flex">
                        <ul class="d-flex flex-row pl-0 mr-3">
                            <li class="px_12 p-2 border bg-dark text-light">投稿順</li>
                            <li class="px_12 p-2 border">いいね順</li>
                            <li class="px_12 p-2 border">閲覧数順</li>
                        </ul>
                        <ul class="d-flex flex-row pl-0">
                            <li class="px_12 p-2 border bg-dark text-light">すべて</li>
                            <li class="px_12 p-2 border">イラスト</li>
                            <li class="px_12 p-2 border">小説</li>
                        </ul>
                    </div>

                    <ul class="row">
                        @foreach ($works as $work)
                        <li class="border p-2 mr-3 mb-3 col-sm-2">
                            <div class="pb-1"><img src="/img/worksample.jpg" alt="" class="w-100"></div>
                            <div class="text-center pb-1"><a href="detail/{{$work->id}}" class="px_12">{{$work->title}}</a></div>
                            <div class="d-flex justify-content-center mb-2">
                                <div class="p-1 border px_10 text-center bg-light mr-1"><b>5</b><br>いいね</div>
                                <div class="p-1 border px_10 text-center bg-light"><b>100</b><br>閲覧数</div>
                            </div>
                            <div>
                                <ul class="d-flex flex-row justify-content-center mx-auto pr-3 pl-3">
                                    <li class="border rounded-circle px_12 w-25 text-center mr-1">&#9829;</li>
                                    <li class="border rounded-circle px_12 w-25 text-center mr-1"><a href="#"><i class="fas fa-edit"></i></a></li>
                                    <li class="border rounded-circle px_12 w-25 text-center"><i class="fas fa-trash-alt"></i></li>
                                </ul>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection