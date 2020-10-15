<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Skill;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseTransactions;
     
    public function testExample()
    {
        //UserControllerにおけるルーティングテスト
        //mypage遷移テスト
        //未認証の場合ログイン画面へ遷移する
        $response = $this->get(route('mypage'));

        $response->assertStatus(302)
            ->assertRedirect('login');

        //未認証edit遷移テスト
        $response = $this->get(route('mypage.edit'));
        
        $response->assertStatus(302)
            ->assertRedirect('login');

    }
}
