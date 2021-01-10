@extends('layouts.admin.layout')

@section('title', 'MyLearningPost ダッシュボード')

@section('scripts')
@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="wrapper-title">
            <h3>ダッシュボード</h3>
        </div>
        <div class="boxes">
            <a href="{{ route('admin.post') }}" class="box">
                <i class="far fa-newspaper icon"></i>
                <p>投稿管理</p>
            </a>
            <a href="{{ route('admin.comment') }}" class="box">
                <i class="far fa-comment icon"></i>
                <p>コメント管理</p>
            </a>
            <a href="{{ route('admin.user') }}" class="box">
                <i class="far fa-user icon"></i>
                <p>ユーザー管理</p>
            </a>
            <a href="{{ route('admin.skill') }}" class="box">
                <i class="fab fa-leanpub icon"></i>
                <p>スキル管理</p>
            </a>
        </div>
    </div>
</div>
@endsection