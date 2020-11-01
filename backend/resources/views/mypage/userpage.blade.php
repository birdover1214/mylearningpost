@extends('layouts.layout')

@section('title', 'MyLearningPost ユーザーページ')

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
<script src="{{ asset('js/chart.js') }}" defer></script>
@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper" data-id="{{ $user->id }}">
        <div class="userpage-title-wrapper mobile">
            <h1 class="userpage-title bold">
            @if($auth->id === $user->id)
                マイページ
            @else
                {{ $user->name }}さんのページ
            @endif
            </h1>
        </div>
        <div class="userpage-container">
        @include('layouts.flash_message')
            <div class="main-body userpage-body mobile">
                <div class="userpage-userprofile-container">
                    <div class="userprofile-box border-and-bgcolor relative">
                        <div class="userpage-image-wrapper relative">
                            <figure class="relative">
                                <img src="@if($user->user_image)/storage/user_images/{{ $user->user_image }}@else{{ asset('/app-images/no_picture.png') }}@endif" alt="プロフィール画像" class="user-image">
                            </figure>
                        </div>
                        @if($auth->id === $user->id)
                        <div class="profile-edit-wrapper">
                            <a href="/userpage/edit">プロフィールの編集</a>
                        </div>
                        @endif
                        <div class="profile-wrapper mobile top-border">
                            <div class="profile-name">
                                <p class="user-name">{{ $user->name }}</p>
                            </div>
                            <div class="profile-introduction top-border">
                                @if($auth->id === $user->id && $user->introduction == "")
                                    <p class="user-introduction">自己紹介文を書いてみよう！</p>
                                @elseif($user->introduction == "")
                                    <p class="user-introduction">自己紹介文未設定</p>
                                @else
                                    <p class="user-introduction">{{ $user->introduction }}</p>
                                @endif
                            </div>
                            <div class="profile-skills-wrapper top-border">
                                <div class="skills-text">
                                    学習中のスキル
                                </div>    
                                <ul class="profile-skills top-border">
                                    @foreach($user->skills as $skill)
                                        @if($user->posts->whereIn('skill_id', $skill->id)->sum('time') < 6000)
                                        <li class="user-skill">{{ $skill->skill_name }}</li>
                                        @elseif($user->posts->whereIn('skill_id', $skill->id)->sum('time') < 12000)
                                        <li class="user-skill"><i class="fas fa-crown rank2"></i> {{ $skill->skill_name }}</li>
                                        @elseif($user->posts->whereIn('skill_id', $skill->id)->sum('time') < 18000)
                                        <li class="user-skill"><i class="fas fa-crown rank3"></i> {{ $skill->skill_name }}</li>
                                        @else
                                        <li class="user-skill"><i class="fas fa-crown rank4"></i> {{ $skill->skill_name }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="userpage-totaltime-chart-wrapper">
                    <div class="totaltime-container border-and-bgcolor">
                        <p class="totaltime-text bold">スキル別 学習時間TOP3</p>
                        <div class="totaltime-ranking-container">
                            @foreach($skills as $skill)
                                @if($loop->iteration == 4)
                                    @break
                                @endif
                                <div class="totaltime-ranking-content">
                                    @if($times[$loop->index] < 6000)
                                    <p class="totaltime-top3 bold">{{ $skill }}</p>
                                    @elseif($times[$loop->index] < 12000)
                                    <p class="totaltime-top3 bold"><i class="fas fa-crown rank2"></i> {{ $skill }}</p>
                                    @elseif($times[$loop->index] < 18000)
                                    <p class="totaltime-top3 bold"><i class="fas fa-crown rank3"></i> {{ $skill }}</p>
                                    @else
                                    <p class="totaltime-top3 bold"><i class="fas fa-crown rank4"></i> {{ $skill }}</p>
                                    @endif
                                    <p class="totaltimes">
                                        @if(intdiv($times[$loop->index], 60) > 0)
                                            {{ intdiv($times[$loop->index], 60) }}時間
                                        @endif
                                        @if($times[$loop->index] % 60 != 0)
                                            {{ $times[$loop->index] % 60 }}分
                                        @endif
                                        @if(intdiv($times[$loop->index], 60) === 0 && $times[$loop->index] % 60 != 0)
                                            0 分
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                            @if(!count($skills))
                                <div class="totaltime-ranking-content">
                                    <p class="totaltimes">現在学習したスキルはありません</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="chart-container border-and-bgcolor">
                        <div class="chart-menu-container relative">
                            <button class="arrow prev-btn prev-1week fas" data-count="1">&#xf060</button>
                            <button class="arrow prev-btn prev-2week fas" data-count="1">&#xf060</button>
                            <div class="change-chart-buttons-container">
                                <button class="chart-btn" id="btn-1week" disabled>１週間表示</button>
                                <button class="chart-btn" id="btn-2week">２週間表示</button>
                            </div>
                            <button class="arrow next-btn next-1week fas" data-count="-1" disabled>&#xf061</button>
                            <button class="arrow next-btn next-2week fas" data-count="-1" disabled>&#xf061</button>
                        </div>
                        <div class="error-field">
                            <strong>※ データの取得に失敗しました</strong>
                        </div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
