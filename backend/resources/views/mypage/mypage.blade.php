@extends('layouts.layout')

@section('title', 'ShareMyLearning マイページ')

@section('scripts')
<script src="{{ asset('js/chart.js') }}" defer></script>
@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="mypage-title-wrapper mobile">
            <h1 class="mypage-title bold">マイページ</h1>
        </div>
        <div class="mypage-container">
        @include('layouts.flash_message')
            <div class="main-body mypage-body mobile">
                <div class="userpage-userprofile-container">
                    <div class="userprofile-box border-and-bgcolor relative">
                        <div class="userpage-image-wrapper relative">
                            <figure class="relative">
                                <img src="/storage/user_images/{{ $user->user_image }}" alt="プロフィール画像" class="user-image">
                            </figure>
                        </div>
                        <div class="profile-edit-wrapper">
                            <a href="/mypage/edit">プロフィールの編集</a>
                        </div>
                        <div class="profile-wrapper mobile top-border">
                            <div class="profile-name">
                                <p class="user-name">{{ $user->name }}</p>
                            </div>
                            <div class="profile-introduction top-border">
                                @if($user->introduction == "")
                                    <p class="user-introduction">自己紹介文を書いてみよう！自己紹介文を書いてみよう！自己紹介文を書いてみよう！自己紹介文を書いてみよう！自己紹介文を書いてみよう！自己紹介文を書いてみよう！自己紹介文を書いてみよう！自己紹介文を書いて</p>
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
                                        @if($skill->pivot->skill_rank === 1)
                                        <li class="user-skill">{{ $skill->skill_name }}</li>
                                        @elseif($skill->pivot->skill_rank === 2)
                                        <li class="user-skill"><i class="fas fa-crown rank2"></i>{{ $skill->skill_name }}</li>
                                        @elseif($skill->pivot->skill_rank === 3)
                                        <li class="user-skill"><i class="fas fa-crown rank3"></i>{{ $skill->skill_name }}</li>
                                        @elseif($skill->pivot->skill_rank === 4)
                                        <li class="user-skill"><i class="fas fa-crown rank4"></i>{{ $skill->skill_name }}</li>
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
                            @foreach($user->times_largest as $times)
                                @if($loop->iteration > 3)
                                    @break
                                @endif
                                <div class="totaltime-ranking-content">
                                    @if($times->pivot->skill_rank === 1)
                                    <p class="totaltime-top3 bold">{{ $times->skill_name }}</p>
                                    @elseif($times->pivot->skill_rank === 2)
                                    <p class="totaltime-top3 bold"><i class="fas fa-crown rank2"></i>{{ $times->skill_name }}</p>
                                    @elseif($times->pivot->skill_rank === 3)
                                    <p class="totaltime-top3 bold"><i class="fas fa-crown rank3"></i>{{ $times->skill_name }}</p>
                                    @elseif($times->pivot->skill_rank === 4)
                                    <p class="totaltime-top3 bold"><i class="fas fa-crown rank4"></i>{{ $times->skill_name }}</p>
                                    @endif
                                    <p class="totaltimes">{{ $times->pivot->total_time }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="chart-container border-and-bgcolor">
                        <div class="chart-menu-container">
                            <a class="prev-btn"><i class="fas fa-caret-left"></i></a>
                            <div class="change-chart-buttons-container">
                                <button class="chart-btn" id="1week-btn">１週間表示</button>
                                <button class="chart-btn" id="2week-btn">２週間表示</button>
                            </div>
                            <a class="next-btn"><i class="fas fa-caret-right"></i></a>
                        </div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
