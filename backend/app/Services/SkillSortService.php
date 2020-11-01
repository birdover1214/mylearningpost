<?php

namespace App\Services;

use App\Models\Post;

class SkillSortService {

    public static function sort($user)
    {
        //学習時間の多い順にスキルをソートする
        //ユーザーの投稿からスキル名と学習時間を合計したコレクションを取得
        $datas = Post::where('user_id', $user->id)->join('skills', 'posts.skill_id', '=', 'skills.id')->get()
        ->groupBy(function($row) {
            return $row->skill_name;
        })->map(function($skill) {
            return $skill->sum('time');
        });
        //昇順に並び替え
        $data = $datas->sort();
        //コレクションから連想配列にする
        $array = $data->all();
        //配列を降順にする
        $sort = array_reverse($array);
        //キー(スキル名)の配列と値(合計学習時間)の配列に分ける
        $skills = array_keys($sort);
        $times = array_values($sort);

        return [$skills, $times];
    }
}