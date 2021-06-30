@extends('layouts.app')

@section('content')
<div class="container">
    <div class="title bg-secondary text-white border p-2 w-75 m-auto">
        <span>検索結果</span>
    </div>
    <div class="border p-2 w-75 m-auto">
        <div class="d-flex">
            <div class="mr-1">
                <a href="/search?search_method={{$search_method}}&search={{$keyword}}&order=new&sort={{$sort}}" class="btn @if($order == "new") btn-dark @else btn-outline-dark @endif">新しい順</a>
            </div>
            <div class="mr-1">
                <a href="/search?search_method={{$search_method}}&search={{$keyword}}&order=old&sort={{$sort}}" class="btn @if($order == "old") btn-dark @else btn-outline-dark @endif">古い順</a>
            </div>
            <div class="ml-4 mr-1">
                <a href="/search?search_method={{$search_method}}&search={{$keyword}}&order={{$order}}&sort=all" class="btn  @if($sort != "novel" && $sort != "illust") btn-dark @else btn-outline-dark @endif">全て</a>
            </div>
            <div class="mr-1">
                <a href="/search?search_method={{$search_method}}&search={{$keyword}}&order={{$order}}&sort=illust" class="btn @if($sort == "illust") btn-dark @else btn-outline-dark @endif">イラスト</a>
            </div>
            <div class="mr-1">
                <a href="/search?search_method={{$search_method}}&search={{$keyword}}&order={{$order}}&sort=novel" class="btn @if($sort == "novel") btn-dark @else btn-outline-dark @endif">小説</a>
            </div>
        </div>
    </div>
    <div class="w-75 m-auto row">
        @foreach ($works as $work)
        <div class="col-sm-6 border p-3">
            <div class="row">
                <div class="col-md-3">
                    @isset ($work->thumbnail)
                        <img src="{{$work->thumbnail}}" alt="サムネイル" class="w-100">
                    @else
                        <img src="/img/worksample.jpg" alt="サムネイル" class="w-100">
                    @endisset
                    <div class="text-center mt-2">
                        <span class="border p-1">♥</span>
                        <span class="border p-1">★</span>
                    </div>
                </div>
                <div class="col-md-9">
                    <p class="small m-0 p-0">{{$work->created_at}}</p>
                    <a href="../works/detail/{{$work->id}}">{{$work->title}}</a>
                    <p>{{str_limit($work->caption, 120, '　…')}}</p>
                    <div>
                        <div class="flex-row">
                            @if ($work->type == 1)
                                <span class="p-1 bg-secondary small text-light">イラスト</span>
                            @elseif ($work->type == 2)
                                <span class="p-1 bg-secondary small text-light">小説</span>
                            @endif
    
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
                            @switch($work->age_status)
                                @case(2)
                                    <span class="p-1 bg-danger small text-light">R18</span>
                                    @break
                                @case(3)
                                    <span class="p-1 bg-danger small text-light">R18G</span>
                                    @break
                                @default
                                    @break
                            @endswitch
                        </div>
                        {{-- <div class="flex-row mt-1">
                            @foreach($work->tags as $tag)
                                <span class="small pr-2"><a href="#">{{$tag->tag}}</a></span>
                            @endforeach
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{$works->links()}}
</div>
@endsection
