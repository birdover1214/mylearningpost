@extends('layouts.layout')

@section('title', 'ShareMyLearning マイページ')

@section('scripts')

@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="mypage-title-wrapper mobile">
            <h1 class="mypage-title bold">マイページ</h1>
        </div>
        <div class="mypage-container">
            <div class="main-body mobile">
                <div class="userpage-userprofile-container">
                    <div class="userprofile-box relative">
                        <div class="userpage-image-wrapper relative">
                            <form class="send-image-form" method="POST" enctype="multipart/form-data">
                                <label for="user_image" class="setting-user-image">
                                    <figure class="relative">
                                        <img src="/storage/user_images/{{ $user->user_image }}" alt="プロフィール画像" class="user-image">
                                        <p class="change-image-text">画像の変更</p>
                                    </figure>
                                    <input type="file" id="user_image" name="user_image" accept="image/png, image/jpeg">
                                </label>
                                <button class="submit-image">プロフィール画像の変更</button>
                            </form>
                        </div>
                        <div class="userpage-profile-wrapper mobile">
                            <div class="profile-name">

                            </div>
                            <div class="profile-skills">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="userpage-totaltime-wrapper">

                </div>
                <div class="userpage-graph-wrapper">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
