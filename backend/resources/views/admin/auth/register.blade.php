@extends('layouts.admin.layout')

@section('title', 'MyLearningPost 管理者登録')

@section('scripts')

@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="main-head-wrapper title-wrapper mobile">
            <h1 class="page-title bold admin-title">管理者登録</h1>
        </div>
        <div class="main-body mobile">
            <form method="POST" action="{{ route('admin.register') }}">
                @csrf

                <div class="form-input">
                    <label for="name" class="label-text mobile">
                        管理者名
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>
                    <div class="input-wrapper">
                        <input id="name" type="text" class="input-text mobile" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    </div>
                </div>

                <div class="form-input">
                    <label for="email" class="label-text nobile">
                        メールアドレス
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>
                    <div class="input-wrapper">
                        <input id="email" type="email" class="input-text mobile" name="email" value="{{ old('email') }}" required autocomplete="email">

                    </div>
                </div>

                <div class="form-input">
                    <label for="password" class="label-text mobile">
                        パスワード
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>
                    <div class="input-wrapper">
                        <input id="password" type="password" class="input-text mobile" name="password" required autocomplete="new-password">

                    </div>
                </div>

                <div class="form-input">
                    <label for="password-confirm" class="label-text mobile">パスワード(再入力)</label>

                    <div class="input-wrapper">
                        <input id="password-confirm" type="password" class="input-text mobile" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-button">
                    <div class="button-container">
                        <button type="submit" class="btn-signup">
                            登録して始める
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
@endsection
