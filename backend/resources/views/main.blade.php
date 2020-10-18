@extends('layouts.layout')

@section('title', 'MyLearningPost')

@section('scripts')
<script src="{{ asset('js/counter.js') }}" defer></script>
@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        @include('layouts.flash_message')
        <div class="main-container relative">
            <div class="search-post-wrapper">
                <div class="search-container">
                    <form action="{{ url('/search') }}" method="GET" id="search-form">
                        @csrf
                        <input type="search" name="search" id="input-search" placeholder="検索内容を入力">
                        <input type="submit" id="search-btn" value="検索">
                    </form>
                </div>
                <div class="new-post-container">
                    <button id="form-post-btn">投稿する</button>
                </div>
            </div>
            <div class="new-post-wrapper">
                <span class="edit-post-text bold">※ 投稿内容の編集中です</span>
                <form action="" method="POST" id="form-post">
                    @csrf
                    <div class="form-post">
                        <div class="form-skill center">
                            <label for="skill" class="select-skill-text">
                                学習したスキルを選択：
                            </label>
                            <span class="error-field">
                                <strong class="select-error"></strong>
                            </span>
                            <div class="select-wrapper">
                                <select name="skill" id="skill">
                                    @foreach($user->skills as $skill)
                                        <option value="{{ $skill->pivot->skill_id }}">{{ $skill->skill_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-time center relative">
                            <span class="error-field absolute">
                                <strong class="time-error"></strong>
                            </span>
                            <label for="time" class="input-time-text">
                                学習時間を入力：
                            </label>
                            <div class="input-wrapper">
                                <input type="number" name="time" id="time">
                                分
                            </div>
                        </div>
                    </div>
                    <div class="form-text">
                        <span class="error-field">
                            <strong class="comment-error"></strong>
                        </span>
                        <div class="input-wrapper">
                            <textarea name="comment" id="comment" class="input-textarea" placeholder="学習内容や感想などを入力"></textarea>
                            <div class="text-count mobile">
                                <span class="text-counter">0</span>/100
                            </div>
                        </div>
                    </div>
                    <div class="form-submit relative">
                        <button type="submit" id="submit-post" class="btn-submit">投稿</button>
                        <button type="submit" id="edit-post" class="btn-submit">編集</button>
                    </div>
                </form>
            </div>
            <div class="posts-wrapper relative">
                <div class="posts-list-container">
                    <ul class="posts-list">
                        @foreach($posts as $post)
                            <li class="posts-contents-list relative">
                                <div class="post-user-image-wrap center">
                                    <a href="@if($user->id === $post->user_id) /mypage @else /userpage/{{ $post->user_id }} @endif">
                                        <img src="@if($post->user->user_image)/storage/user_images/{{ $post->user->user_image }}@else{{ asset('/app-images/no_picture.png') }}@endif" alt="{{ $post->user->name }}" class="post-user-image">
                                    </a>
                                    <p class="post-user-name">{{ $post->user->name }}</p>
                                    <div class="post-icons-wrap relative">
                                        @if($post->users()->where('user_id', $user->id)->exists())
                                            <button class="attach-favorite" data-id="{{ $post->id }}" style="display: none">
                                                <i class="far fa-heart"></i>
                                            </button>
                                            <button class="detach-favorite" data-id="{{ $post->id }}">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                            <span class="favorites-counter">{{ $post->users()->count() }}</span>
                                        @else
                                            <button class="attach-favorite" data-id="{{ $post->id }}">
                                                <i class="far fa-heart"></i>
                                            </button>
                                            <button class="detach-favorite" data-id="{{ $post->id }}" style="display: none">
                                                <i class="fas fa-heart"></i>
                                            </button>
                                            <span class="favorites-counter">{{ $post->users()->count() }}</span>
                                        @endif
                                        <a href='{{ url("/post/{$post->id}") }}' class="icon-comment">
                                            <i class="far fa-comment-alt"></i>
                                            {{ $post->talks()->count() }}
                                        </a>
                                    </div>
                                </div>
                                <div class="post-contents">
                                    <div class="post-skill-time-wrap">
                                        <label for="skill" class="post-skill-text">
                                            学習したスキル： 
                                            <span>
                                                @if(App\Models\Post::where('skill_id', $post->skill_id)->where('user_id', $post->user_id)->sum('time') >= 18000)
                                                <i class="fas fa-crown rank4"></i> 
                                                @elseif(App\Models\Post::where('skill_id', $post->skill_id)->where('user_id', $post->user_id)->sum('time') >= 12000)
                                                <i class="fas fa-crown rank3"></i> 
                                                @elseif(App\Models\Post::where('skill_id', $post->skill_id)->where('user_id', $post->user_id)->sum('time') >= 6000)
                                                <i class="fas fa-crown rank2"></i> 
                                                @endif
                                                {{ $post->skill->skill_name }} 
                                            </span>
                                        </label>
                                        <label for="time" class="post-time-text">学習時間： <span class="post-time">{{ $post->time }}</span> 分</label>
                                    </div>
                                    @if($post->user_id === $user->id)
                                    <div class="post-config-wrap">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                    <div class="post-config-contents">
                                        <div class="post-edit">
                                            <button class="post-edit-btn" data-id="{{ $post->id }}">編集</button>
                                        </div>
                                        <div class="post-delete">
                                            <form action='{{ url("/delete/{$post->id}") }}' method="POST">
                                                @csrf
                                                <button type="submit" class="post-delete-btn">削除</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="post-comment-wrap">
                                        {{ $post->comment }}
                                    </div>
                                    <div class="post-time-wrap">
                                        {{ $post->updated_at }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="pagination-wrapper relative">
                    {{ $posts->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection