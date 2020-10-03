@extends('layouts.layout')

@section('title', 'ShareMyLearning新規登録')

@section('scripts')

@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="main-head-wrapper title-wrapper mobile">
            <h1 class="page-title bold">Sign up</h1>
        </div>
        <div class="main-body mobile">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-input">
                    <label for="name" class="label-text">
                        ニックネーム
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
                    <label for="email" class="label-text">
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
                    <label for="password" class="label-text">
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
                    <label for="password-confirm" class="label-text">パスワード(再入力)</label>

                    <div class="input-wrapper">
                        <input id="password-confirm" type="password" class="input-text mobile" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="form-input">
                    <label for="skills-confirm" class="label-text">
                        学習中または興味のあるものを10個まで選んでください(最低1つは選択してください)
                        @error('skills')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                    </label>
                    <div class="check-wrapper mobile">
                        @foreach($skills as $skill)
                            <label class="input-checkbox">
                                <input type="checkbox" name="skills[]" class="checkbox-content" value="{{ $skill->id }}">{{ $skill->skill_name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="form-button">
                    <div class="button-container">
                        <button type="submit" class="btn-signup">
                            登録して始める
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
