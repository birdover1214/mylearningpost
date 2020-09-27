<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <script src="{{ asset('js/app.js') }}" defer></script>
    @yield('scripts')

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-light navbar-expand-md">
            <div class="header-content">
                <a class="navbar-brand" href="{{ url('/') }}">
                    ShareMyLearning
                </a>
                <ul class="nav-list">
                    <!-- ログイン判定 -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">ゲストログイン</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">新規登録</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-dropdown" href="">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="header-dropdown">
                                <a href="{{ url('/mypage') }}" class="link-mypage">
                                    <span>マイページ</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <input type="submit" value="ログアウト">
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
    </header>

        <main class="py-4">
            @yield('content')
        </main>
</body>
</html>
