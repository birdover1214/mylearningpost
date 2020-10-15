@extends('layouts.layout')

@section('title', 'ShareMyLearning プロフィール編集')

@section('scripts')
<script src="{{ asset('js/counter.js') }}" defer></script>
@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="main-head-wrapper title-wrapper mobile">
            <h1 class="page-title bold">プロフィール編集</h1>
        </div>
        <div class="main-body mobile">
            @include('layouts.flash_message')
            <form method="POST" action="{{ url('/mypage/update') }}" id="form-edit" enctype="multipart/form-data">
                @csrf
                <div class="form-input">
                    <label for="user_image" class="label-image">
                        <figure>
                            <img src="/storage/user_images/{{ $user->user_image }}" class="image-preview" alt="">
                            <p>画像の変更</p>
                        </figure>
                        <input type="file" id="user_image" name="user_image" accept="image/png, image/jpeg">
                        <span class="error-field">
                            <strong class="user_image-error"></strong>
                        </span>
                    </label>
                </div>
                <div class="form-input">
                    <label for="name" class="label-text mobile">
                        ニックネーム(20文字以内)
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
                    <label for="introduction" class="label-text mobile">
                        プロフィールコメント(100文字以内)
                        @error('introduction')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="error-field">
                            <strong class="introduction-error"></strong>
                        </span>
                    </label>
                    <div class="input-wrapper">
                        <textarea id="introduction" class="input-textarea mobile" name="introduction">{{ old('introduction', $user->introduction) }}</textarea>
                        <div class="text-count mobile">
                            <span class="text-counter">0</span>/100
                        </div>
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
                    <label for="skills-confirm" class="label-text mobile">
                        スキルを選択(10個まで。最低1個は選択してください)
                        @error('skills')
                            <span class="invalid-feedback" role="alert">
                                <strong>※{{ $message }}</strong>
                            </span>
                        @enderror
                        <span class="error-field">
                            <strong class="skills-error"></strong>
                        </span>
                    </label>
                    <div class="check-wrapper mobile">
                        @foreach($skills as $skill)
                            <label class="input-checkbox">
                                <input type="checkbox" name="skills[]" class="checkbox-content" value="{{ $skill->id }}"
                                    {{ in_array($skill->id, $selected_ids, true) ? 'checked="checked"' : "" }} >{{ $skill->skill_name }}
                            </label>
                        @endforeach
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
                            プロフィールを変更
                        </button>
                    </div>
                </div>
                <div class="check-edit-wrapper check">
                    <div class="check-edit-container">
                        <div class="check-edit-content">
                            <h3 class="check-edit-main-message bold">プロフィール更新確認</h3>
                            <p class="check-edit-sub-message">
                                プロフィールの内容を変更してよろしいですか？
                            </p>
                            <div class="check-edit-button-wrap">
                                <input type="submit" id="submit-edit" class="check-btn change-btn" value="変更する">
                                <input type="button" id="cancel-edit" class="check-btn" value="キャンセル">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <form method="POST" action="{{ route('user.delete') }}" id="form-delete">
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
                            <h3 class="check-edit-main-message bold">ユーザー登録の解除確認</h3>
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
