@extends('layouts.admin.layout')

@section('title', 'MyLearningPost ユーザー管理')

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="wrapper-title">
            <a href="{{ route('admin.user') }}">
                <h3>ユーザー管理</h3>
            </a>
        </div>
        <div class="search-wrapper">
            <form action="{{ route('admin.user.search') }}" method="GET" id="search-form">
                @csrf
                <input type="search" name="search" class="admin-search" placeholder="ID,ユーザー名,メールアドレス,自己紹介文から検索">
                <input type="submit" id="search-btn" value="検索">
            </form>
        </div>
        <div class="posts">
            <table border="2" class="admin__table">
                <tr class="admin__table__head user_head">
                    <th class="admin__table__user__id">ID</th>
                    <th class="admin__table__user__image">プロフィール画像</th>
                    <th class="admin__table__name">ユーザー名</th>
                    <th class="admin__table__email">メールアドレス</th>
                    <th class="admin__table__introduction">自己紹介文</th>
                    <th class="admin__table__created_at">登録日時</th>
                    <th class="admin__table__button"><i class="far fa-trash-alt"></i></th>
                </tr>
                @foreach($users as $user)
                <tr class="admin__table__items user_items">
                    <td>{{ $user->id }}</td>
                    <td>
                        <img src="@if($user->user_image)/storage/user_images/{{ $user->user_image }}@else{{ asset('/app-images/no_picture.png') }}@endif" alt="{{ $user->name }}" class="admin__table__user-image">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->introduction)
                            {{ $user->introduction }}
                        @else
                            未設定
                        @endif
                    </td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <form action='{{ route("admin.user.delete", ["id" => $user->id]) }}' method="POST">
                            @csrf
                            <button type="submit" class="admin-delete-btn">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="pagination-wrapper relative">
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection