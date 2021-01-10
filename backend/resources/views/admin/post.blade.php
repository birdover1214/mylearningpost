@extends('layouts.admin.layout')

@section('title', 'MyLearningPost 投稿管理')

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="wrapper-title">
            <a href="{{ route('admin.post') }}">
                <h3>投稿管理</h3>
            </a>
        </div>
        <div class="search-wrapper">
            <form action="{{ route('admin.post.search') }}" method="GET" id="search-form">
                @csrf
                <input type="search" name="search" class="admin-search" placeholder="ユーザー名,スキル名,投稿内容から検索">
                <input type="submit" id="search-btn" value="検索">
            </form>
        </div>
        <div class="posts">
            <table border="2" class="admin__table">
                <tr class="admin__table__head">
                    <th class="admin__table__id">投稿ID</th>
                    <th class="admin__table__user">ユーザー名</th>
                    <th class="admin__table__skill">スキル名</th>
                    <th class="admin__table__time">学習時間</th>
                    <th class="admin__table__comment">投稿内容</th>
                    <th class="admin__table__button"><i class="far fa-trash-alt"></i></th>
                </tr>
                @foreach($posts as $post)
                <tr class="admin__table__items">
                    <td>{{ $post->id }}</td>
                    <td>{{ App\Models\User::find($post->user_id)->name }}</td>
                    <td>{{ App\Models\Skill::find($post->skill_id)->skill_name }}</td>
                    <td>{{ $post->time }} 分</td>
                    <td>{{ $post->comment }}</td>
                    <td>
                        <form action='{{ route("admin.post.delete", ["id" => $post->id]) }}' method="POST">
                            @csrf
                            <button type="submit" class="admin-delete-btn">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="pagination-wrapper relative">
            {{ $posts->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection