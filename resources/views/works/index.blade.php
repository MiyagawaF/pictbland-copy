@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">作品の管理</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul>
                        <li>作品１</li>
                        <li>作品２</li>
                        <li>作品３</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection