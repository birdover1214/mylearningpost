@extends('layouts.layout')

@section('title', 'ShareMyLearning 投稿詳細ページ')

@section('scripts')
<script src="{{ asset('js/counter.js') }}" defer></script>
@endsection

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        @include('layouts.flash_message')
        <div class="post-container relative">
            <div class="post-detail-container">
                <div class="post-user-image-wrap center">
                    <img src="/storage/user_images/{{ $post->user->user_image }}" alt="{{ $post->user->name }}" class="post-user-image">
                    <p class="post-user-name">{{ $post->user->name }}</p>
                </div>
                <div class="post-contents">
                    <div class="post-skill-time-wrap">
                        <label for="skill" class="post-skill-text">
                            学習したスキル： 
                            <span>
                                @if(App\Models\Skill::find($post->skill_id)->users->find($post->user_id)->pivot->skill_rank === 2)
                                <i class="fas fa-crown rank2"></i>
                                @elseif(App\Models\Skill::find($post->skill_id)->users->find($post->user_id)->pivot->skill_rank === 3)
                                <i class="fas fa-crown rank3"></i>
                                @elseif(App\Models\Skill::find($post->skill_id)->users->find($post->user_id)->pivot->skill_rank === 4)
                                <i class="fas fa-crown rank4"></i>
                                @endif
                                {{ $post->skill->skill_name }} 
                            </span>
                        </label>
                        <label for="time" class="post-time-text">学習時間： {{ $post->time }} 分</label>
                    </div>
                    <div class="post-comment-wrap">
                        {{ $post->comment }}
                    </div>
                    <div class="post-time-wrap">
                        {{ $post->updated_at }}
                    </div>
                </div>
            </div>
            <div class="talks-container">
                <div class="talks-text　bold">コメント一覧</div>
                <hr>
                <div class="talks-body">
                    @foreach($talks as $talk)
                        <div class="talks-list relative">
                            <div class="talks-user-image-wrap">
                                <a href="@if($user->id === $post->user_id) /mypage @else /userpage/{{ $talk->user_id }} @endif">
                                    <img src="/storage/user_images/{{ $talk->user->user_image }}" alt="{{ $talk->user->name }}" class="talks-user-image">
                                </a>
                                {{ $talk->user->name }}
                            </div>
                            <div class="talks-comment-wrap">
                                {{ $talk->comment }}
                            </div>
                            <div class="talks-time-wrap">
                                {{ $talk->created_at }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pagination-wrapper">
                    {{ $talks->links() }}
                </div>
            </div>
            <hr>
            <div class="talks-comment-countainer">
                <form action="" method="POST" class="create-comment-form">
                    <div class="comment-body">
                        <span class="error-field">
                            <strong class="comment-error"></strong>
                        </span>
                        <textarea name="comment" id="talks-comment" class="input-textarea" data-post-id="{{ $post->id }}" placeholder="誹謗中傷や不快になるようなコメントはお控えください"></textarea>
                        <div class="text-count mobile">
                            <span class="text-counter">0</span>/100
                        </div>
                    </div>
                    <div class="comment-submit-wrap">
                        <button type="submit" id="comment-btn" class="btn-submit">コメントする</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection