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
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">タイトル</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="caption">本文</label>
                            <textarea class="form-control"  name="caption" id="caption" cols="20" rows="10"></textarea>
                        </div>

                        <a href="/works/add/novelinfo"><input type="" value="次へ" class="btn btn-primary mb-4"></a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
