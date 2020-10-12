<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            
            [
                'user_id' => '1',
                'skill_id' => '17',
                'time' => '240',
                'comment' => '多対多のリレーションを学習しました',
                'created_at' => new Carbon('-13 days'),
                'updated_at' => new Carbon('-13 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '2',
                'time' => '300',
                'comment' => 'VPCの概念の学習とEC2インスタンスを作成しました！',
                'created_at' => new Carbon('-12 days'),
                'updated_at' => new Carbon('-12 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '2',
                'time' => '420',
                'comment' => 'IAMのポリシーの学習を行いました。覚えることが多いですが頑張ります',
                'created_at' => new Carbon('-11 days'),
                'updated_at' => new Carbon('-11 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '17',
                'time' => '600',
                'comment' => 'ポートフォリオのマイページとマイページ編集画面を作成しました',
                'created_at' => new Carbon('-10 days'),
                'updated_at' => new Carbon('-10 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '9',
                'time' => '180',
                'comment' => 'dockerfileの書き方を学習しました',
                'created_at' => new Carbon('-9 days'),
                'updated_at' => new Carbon('-9 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '9',
                'time' => '330',
                'comment' => '昨日に引き続きdockerfileの学習を行いました',
                'created_at' => new Carbon('-8 days'),
                'updated_at' => new Carbon('-8 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '17',
                'time' => '540',
                'comment' => 'dockerを使ってLaravelの環境構築を行いました',
                'created_at' => new Carbon('-7 days'),
                'updated_at' => new Carbon('-7 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '17',
                'time' => '360',
                'comment' => '中間テーブルのデータ取得が難しい・・・',
                'created_at' => new Carbon('-6 days'),
                'updated_at' => new Carbon('-6 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '17',
                'time' => '480',
                'comment' => '中間テーブルのデータ取得問題が解決しました！！',
                'created_at' => new Carbon('-5 days'),
                'updated_at' => new Carbon('-5 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '17',
                'time' => '570',
                'comment' => 'ポートフォリオのメインページの作成を進めました',
                'created_at' => new Carbon('-4 days'),
                'updated_at' => new Carbon('-4 days'),
            ],
            
            [
                'user_id' => '1',
                'skill_id' => '17',
                'time' => '630',
                'comment' => '昨日に引き続きポートフォリオのメインページを作成しています。',
                'created_at' => new Carbon('-3 days'),
                'updated_at' => new Carbon('-3 days'),
            ],
        ]);
    }
}