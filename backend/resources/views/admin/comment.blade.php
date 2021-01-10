@extends('layouts.admin.layout')

@section('title', 'MyLearningPost コメント管理')

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="wrapper-title">
            <a href="{{ route('admin.comment') }}">
                <h3>コメント管理</h3>
            </a>
        </div>
        <div class="search-wrapper">
            <form action="{{ route('admin.comment.search') }}" method="GET" id="search-form">
                @csrf
                <input type="search" name="search" class="admin-search" placeholder="投稿ID,ユーザー名,コメント内容から検索">
                <input type="submit" id="search-btn" value="検索">
            </form>
        </div>
        <div class="posts">
            <table border="2" class="admin__table">
                <tr class="admin__table__head">
                    <th class="admin__table__comment__id">コメントID</th>
                    <th class="admin__table__post">投稿ID</th>
                    <th class="admin__table__comment__user">ユーザー名</th>
                    <th class="admin__table__comment">コメント内容</th>
                    <th class="admin__table__button"><i class="far fa-trash-alt"></i></th>
                </tr>
                @foreach($comments as $comment)
                <tr class="admin__table__items">
                    <td>{{ $comment->id }}</td>
                    <td>{{ App\Models\Post::find($comment->post_id)->id }}</td>
                    <td>{{ App\Models\User::find($comment->user_id)->name }}</td>
                    <td>{{ $comment->comment }}</td>
                    <td>
                        <form action='{{ route("admin.comment.delete", ["id" => $comment->id]) }}' method="POST">
                            @csrf
                            <button type="submit" class="admin-delete-btn">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="pagination-wrapper relative">
            {{ $comments->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection