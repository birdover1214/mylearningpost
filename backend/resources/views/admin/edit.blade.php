@extends('layouts.admin.layout')

@section('title', 'MyLearningPost 管理者情報編集')

@section('scripts')
@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="main-head-wrapper title-wrapper mobile">
            <h1 class="page-title bold admin-title">管理者情報編集</h1>
        </div>
        @include('layouts.flash_message')
        <div class="main-body mobile">
            <form method="POST" action="{{ route('admin.update') }}" id="form-edit">
                @csrf
                <div class="form-input">
                    <label for="name" class="label-text mobile">
                        管理者名(20文字以内)
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="error-field">
                            <strong class="name-error"></strong>
                        </span>
                    </label>
                    <div class="input-wrapper">
                        <input id="name" type="text" class="input-text mobile" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="form-input">
                    <label for="email" class="label-text mobile">
                        メールアドレス
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="error-field">
                            <strong class="email-error"></strong>
                        </span>
                    </label>
                    <div class="input-wrapper">
                        <input id="email" type="email" class="input-text mobile" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                    </div>
                </div>
                <div class="form-input">
                    <label for="password" class="label-text mobile">
                        パスワード(8文字以上。変更しない場合は入力しないでください)
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="error-field">
                            <strong class="password-error"></strong>
                        </span>
                    </label>
                    <div class="input-wrapper">
                        <input id="password" type="password" class="input-text mobile" name="password">
                    </div>
                </div>
                <div class="form-input">
                    <label for="password-confirm" class="label-text mobile">パスワード(再入力)</label>

                    <div class="input-wrapper">
                        <input id="password-confirm" type="password" class="input-text mobile" name="password_confirmation">
                    </div>
                </div>
                <div class="form-input">
                    <label for="current_password" class="label-text mobile">
                        プロフィールを変更する場合、現在使用しているパスワードを入力してください
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="error-field">
                            <strong class="current-password-error"></strong>
                        </span>
                    </label>
                    <div class="input-wrapper">
                        <input id="current_password" type="password" class="input-text mobile" name="current_password" required autocomplete="current-password">
                    </div>
                </div>
                <div class="form-button">
                    <div class="button-container">
                        <button type="submit" id="btn-edit" class="btn-submit mobile">
                            管理者情報を変更
                        </button>
                    </div>
                </div>
                <div class="check-edit-wrapper check">
                    <div class="check-edit-container">
                        <div class="check-edit-content">
                            <h3 class="check-edit-main-message bold">管理者情報更新確認</h3>
                            <p class="check-edit-sub-message">
                                管理者情報を変更してよろしいですか？
                            </p>
                            <div class="check-edit-button-wrap">
                                <input type="submit" id="submit-edit" class="check-btn change-btn" value="変更する">
                                <input type="button" id="cancel-edit" class="check-btn" value="キャンセル">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form method="POST" action="{{ route('admin.delete') }}" id="form-delete">
                @csrf
                <div class="form-button">
                    <div class="button-container">
                        <button type="submit" id="btn-user-delete" class="btn-submit btn-user-delete mobile">
                            登録の解除
                        </button>
                    </div>
                </div>
                <div class="check-delete-wrapper check">
                    <div class="check-edit-container">
                        <div class="check-edit-content">
                            <h3 class="check-edit-main-message bold">管理者登録の解除確認</h3>
                            <p class="check-edit-sub-message">
                                <strong>登録の解除</strong>
                                を行います。よろしいですか？
                            </p>
                            <div class="check-edit-button-wrap">
                                <input type="submit" id="submit-delete" class="check-btn user-delete-btn" value="解除する">
                                <input type="button" id="cancel-delete" class="check-btn" value="キャンセル">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
