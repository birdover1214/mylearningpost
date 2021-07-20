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

    <script src="{{ asset('js/admin/app.js') }}" defer></script>
    @yield('scripts')

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar-content">
                <a class="navbar-title" href="{{ route('admin.home') }}">
                    MyLearningPost
                </a>
                <ul class="nav-list">
                    <!-- ログイン判定 -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.login') }}">管理者ログイン</a>
                        </li>
                        @if (Route::has('admin.register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.register') }}">管理者登録</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item nav-dropdown nav-admin">
                            <a class="btn-dropdown" href="">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="navbar-dropdown">
                                <div class="dropdown-mypage">
                                    <a href="{{ route('admin.edit') }}" class="link-admin-edit">
                                        <span>管理者情報変更</span>
                                    </a>
                                </div>
                                <div class="dropdown-logout">
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
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
    </footer>
</body>
</html>
