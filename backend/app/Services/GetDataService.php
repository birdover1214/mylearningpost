<?php

namespace App\Services;

use App\Models\Post;
use Carbon\Carbon;

class GetDataService {

    public static function getData($request)
    {
        //$request->countがセットされていなければ0を設定
        if($request->count == null) {
            $request->count = 0;
            $request->week = '1week';
        }

        //取得するデータの範囲を変数に代入する
        $week = '';
        if($request->week === '1week') {
            $week = 7;
        }else {
            $week = 14;
        }

        //グラフ描画の為のデータを挿入する変数の初期化
        $data = [];
        //データ取得開始日を計算する
        $startDay = new Carbon('today');
        $startDay->subDay($week * $request->count + $week);
        //データ取得終了日を計算する
        $endDay = new Carbon('today');
        $endDay->subDay($week * $request->count + $week -1);
        //$dataはkeyを日付、valueを学習時間として渡す為、日付を挿入する為の変数を作成し計算
        $setDay = new Carbon('today');
        $setDay->subDay($week * $request->count + $week);

        //1日毎のデータを取得する
        for($i = 0; $i < $week; $i++) {
            //指定された日の学習時間を全て取得
            $times = Post::select('time')->where('user_id', $request->id)->where('created_at', '>=', $startDay->addDay(1))
                ->where('created_at', '<', $endDay->addDay(1))->get();
            //学習時間の合計を求める
            $time = $times->sum('time');
            
            $setDay->addDay(1);
            $day = $setDay->format('m/d');
            $data[$day] = $time;
        }

        return $data;
    }
}