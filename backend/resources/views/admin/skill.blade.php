@extends('layouts.admin.layout')

@section('title', 'MyLearningPost スキル管理')

@section('content')
<div class="main-global-wrapper">
    <div class="main-wrapper">
        <div class="wrapper-title">
            <a href="{{ route('admin.skill') }}">
                <h3>スキル管理</h3>
            </a>
        </div>
        <div class="skill-add-wrapper">
            <form action="{{ route('admin.skill.add') }}" method="POST" id="add-form">
                @csrf
                @error('skill_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <p class="add-text">スキルを追加</p>
                <input type="text" name="skill_name" class="skill_name" placeholder="スキル名を入力してください">
                <input type="submit" id="add-btn" value="追加">
            </form>
        </div>
        <div class="search-wrapper">
            <form action="{{ route('admin.skill.search') }}" method="GET" id="search-form">
                @csrf
                <input type="search" name="search" class="admin-search" placeholder="スキル名で検索">
                <input type="submit" id="search-btn" value="検索">
            </form>
        </div>
        <div class="posts">
            <table border="2" class="admin__table skill_table">
                <tr class="admin__table__head">
                    <th class="admin__table__id">ID</th>
                    <th class="admin__table__skill_name">スキル名</th>
                    <th class="admin__table__button"><i class="far fa-trash-alt"></i></th>
                </tr>
                @foreach($skills as $skill)
                <tr class="admin__table__items skill_items">
                    <td>{{ $skill->id }}</td>
                    <td>{{ $skill->skill_name }}</td>
                    <td>
                        <form action='{{ route("admin.skill.delete", ["id" => $skill->id]) }}' method="POST">
                            @csrf
                            <button type="submit" class="admin-delete-btn">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="pagination-wrapper relative">
            {{ $skills->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection