<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LL2LKRS7X9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-LL2LKRS7X9');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <script src="{{ asset('js/user/app.js') }}" defer></script>
    @yield('scripts')

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">    
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar-content">
                <a class="navbar-title" href="{{ url('/') }}">
                    MyLearningPost
                </a>
                <ul class="nav-list">
                    <!-- ログイン判定 -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">ログイン</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ url('/user/guest') }}" method="POST" id="guest-login-form">
                                @csrf
                                <button type="submit" class="nav-link">ゲストログイン</button>
                            </form>
                        </li>
                        @if (Route::has('user.register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('user.register') }}">新規登録</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item nav-dropdown">
                            <a class="btn-dropdown" href="">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="navbar-dropdown">
                                <div class="dropdown-mypage">
                                    <a href="{{ url('/user/mypage') }}" class="link-mypage">
                                        <span>マイページ</span>
                                    </a>
                                </div>
                                <div class="dropdown-logout">
                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST">
                                        @csrf
                                        <input type="submit" class="btn-logout" value="ログアウト">
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>CopyLight MyLearningPost 2020-2021</p>
        @yield('admin')
    </footer>
</body>
</html>
