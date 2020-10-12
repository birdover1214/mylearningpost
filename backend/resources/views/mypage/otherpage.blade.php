@extends('layouts.layout')

@section('title', 'ShareMyLearning マイページ')

@section('scripts')
<script src="{{ asset('js/chart.js') }}" defer></script>
@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper" data-id="{{ $user->id }}">
        <div class="mypage-title-wrapper mobile">
            <h1 class="mypage-title bold">{{ $user->name }}さんのページ</h1>
        </div>
        <div class="mypage-container">
            <div class="main-body mypage-body mobile">
                <div class="userpage-userprofile-container">
                    <div class="userprofile-box border-and-bgcolor relative">
                        <div class="userpage-image-wrapper other relative">
                            <figure class="relative">
                                <img src="/storage/user_images/{{ $user->user_image }}" alt="プロフィール画像" class="user-image">
                            </figure>
                        </div>
                        <div class="profile-wrapper mobile top-border">
                            <div class="profile-name">
                                <p class="user-name">{{ $user->name }}</p>
                            </div>
                            <div class="profile-introduction top-border">
                                @if($user->introduction == "")
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
                                        @if(App\Models\Post::where('skill_id', $skill->id)->where('user_id', $user->id)->sum('time') < 6000)
                                        <li class="user-skill">{{ $skill->skill_name }}</li>
                                        @elseif(App\Models\Post::where('skill_id', $skill->id)->where('user_id', $user->id)->sum('time') < 12000)
                                        <li class="user-skill"><i class="fas fa-crown rank2"></i> {{ $skill->skill_name }}</li>
                                        @elseif(App\Models\Post::where('skill_id', $skill->id)->where('user_id', $user->id)->sum('time') < 18000)
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
                                    <p class="totaltimes">{{ $times[$loop->index] }}</p>
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
                        <div class="chart-menu-container">
                            <button class="arrow prev-btn prev-1week" data-count="1"><i class="fas fa-caret-left"></i></button>
                            <div class="change-chart-buttons-container">
                                <button class="chart-btn" id="btn-1week" disabled>１週間表示</button>
                                <button class="chart-btn" id="btn-2week">２週間表示</button>
                            </div>
                            <button class="arrow next-btn next-1week" data-count="1"><i class="fas fa-caret-right"></i></button>
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
