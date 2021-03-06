<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand ml-4" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav mr-5">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">新規登録</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">ログイン</a>
            </li>
            @else
            <li class="mr-3">
                <form class="d-flex" action="/search" method="GET">
                    @csrf
                    <div class="row ml-3 mr-2">
                        <div class="form-check pt-3">
                            <input class="form-check-input" type="radio" name="search_method" id="keyword_search" value="keyword_search" @if($search_method == "keyword_search") checked="checked" @endif>
                            <label class="form-check-label" for="keyword_search">キーワード検索</label>
                        </div>
                        <div class="form-check ml-2 pt-3 mr-3">
                            <input class="form-check-input" type="radio" name="search_method" id="tag_search" value="tag_search" @if($search_method == "tag_search") checked="checked" @endif>
                            <label class="form-check-label" for="tag_search">タグ検索</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search" value="{{$keyword}}">
                    </div>
                    <button class="btn btn-outline-success" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="readme">Read Me</a>
            </li>
            @endguest
        </ul>
    </div>
</nav>
@auth
<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
    <div class="container">
        <ul class="navbar-nav ml-auto mr-1">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">ホーム</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                作品投稿
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/works/add/novel">小説作品の投稿</a>
                    <a class="dropdown-item" href="/works/add/illust">イラスト作品の投稿</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/works/index">管理</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                設定
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/users/edit/prof_edit">プロフィールの設定</a>
                    <a class="dropdown-item" href="/users/edit/follow_edit">フォロー受付設定</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
@endauth