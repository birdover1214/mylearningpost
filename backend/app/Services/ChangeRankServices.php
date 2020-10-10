<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Skill;

class ChangeRankServices
{
    //total_timeを加える処理とskill_rankを上げる処理
    public static function addTimeAndRankUp($request) {
        $user = Auth::user();

        //postデータ新規登録とskill_userテーブルのtotal_time,rank更新処理
        //リクエストされたスキルを持つユーザーをEloquentコレクションにて取得
        $skillHasUser = Skill::find($request->skill)->users;
        //Eloquentコレクションのfindメソッドを用いてレコードを特定し、total_timeを取得
        $currentTotalTime = $skillHasUser->find($user->id)->pivot->total_time;

        //更新するtotal_timeの値
        $newTotalTime = $currentTotalTime + $request->time;

        //skill_userテーブルのtotal_time更新
        $user->skills()->syncWithoutDetaching([$request->skill => ['total_time' => $newTotalTime]]);

        //更新後のtotal_timeが一定時間を越えていた場合ランクアップする
        if($newTotalTime >= 18000) {
            $user->skills()->syncWithoutDetaching([$request->skill => ['skill_rank' => 4]]);
        }else if($newTotalTime >= 12000) {
            $user->skills()->syncWithoutDetaching([$request->skill => ['skill_rank' => 3]]);            
        }else if($newTotalTime >= 6000) {
            $user->skills()->syncWithoutDetaching([$request->skill => ['skill_rank' => 2]]);
        }

    }

    //total_timeを減らす処理とskill_rankを下げる処理
    public static function removeTimeAndRankDown($request) {
        $user = Auth::user();

        //対象のpostデータを取得
        $postData = Post::find($request->id);

        //リクエストされた投稿のスキルの学習時間を取得
        $currentTotalTime = Skill::find($postData->skill_id)->users->find($postData->user_id)->pivot->total_time;
        //削除後の総学習時間
        $totalTime = $currentTotalTime - $postData->time;
        
        //skill_userテーブルのtotal_time更新
        $user->skills()->syncWithoutDetaching([$postData->skill_id => ['total_time' => $totalTime]]);

        //更新後のtotal_timeによってランクを変える
        if($totalTime < 6000) {
            $user->skills()->syncWithoutDetaching([$postData->skill_id => ['skill_rank' => 1]]);
        }else if($totalTime < 12000) {
            $user->skills()->syncWithoutDetaching([$postData->skill_id => ['skill_rank' => 2]]);            
        }else if($totalTime < 18000) {
            $user->skills()->syncWithoutDetaching([$postData->skill_id => ['skill_rank' => 3]]);
        }
        
    }
}