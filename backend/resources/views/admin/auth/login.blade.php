@extends('layouts.admin.layout')

@section('title', 'MyLearningPost 管理者ログイン')

@section('scripts')

@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="main-head-wrapper title-wrapper mobile">
            <h1 class="page-title bold admin-title">管理者ログイン</h1>
        </div>
        <div class="login-container">
            <div class="main-body mobile">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="form-input">
                        <label for="email" class="label-text mobile">
                            メールアドレス
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>
                        <div class="input-wrapper">
                            <input id="email" type="email" class="input-text mobile @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>
                    </div>
                    <div class="form-input">
                        <label for="password" class="label-text mobile">
                            パスワード
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </label>
                        <div class="input-wrapper">
                            <input id="password" type="password" class="input-text mobile @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        </div>
                    </div>
                    <div class="form-input">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                パスワードを保存する
                            </label>
                        </div>
                    </div>

                    <div class="form-button">
                        <div class="button-container">
                            <button type="submit" class="btn-submit">
                                Login
                            </button>
                        </div>
                    </div>
                    <div class="link-user">
                        <a href="{{ route('home') }}">メインページ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
