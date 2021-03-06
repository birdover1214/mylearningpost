@extends('layouts.user.layout')

@section('title', 'MyLearningPost')

@section('scripts')

@endsection

@section('content')
<div class="main-global-wrapper top-wrapper">
    <div class="main-wrapper">
        @include('layouts.flash_message')
        <div class="main-head-wrapper">
            <h1 class="toppage-title bold">MyLearningPost</h1>
            <h3 class="page-title-sub">積み重ねの投稿をしよう</h3>
        </div>
        <div class="toppage-images-wrapper">
            <!-- 完成後の画像を3枚程度並べる -->
            <div class="image-content">
                <div class="image-container">
                    <img class="main-img" src="{{ asset('/app-images/top1.png') }}" alt="">
                    <img class="main-img" src="{{ asset('/app-images/top3.png') }}" alt="">
                    <img class="main-img" src="{{ asset('/app-images/top2.png') }}" alt="">
                </div>
                <div class="image-text-container">
                    <p class="image-introduction bold">毎日の学習を投稿しよう</p>
                    <p class="image-introduction bold">わからない所を質問しよう</p>
                    <p class="image-introduction bold">学習時間に応じてランクアップ！</p>
                </div>
            </div>
        </div>
        <div class="toppage-register-wrapper">
            <a href="{{ route('user.register') }}" class="btn-register bold">新規登録</a>
        </div>
    </div>
</div>
@endsection

@section('admin')
<a href="{{ route('admin.login') }}" class="admin-login">管理者ログイン</a>
@endsection