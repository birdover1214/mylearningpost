<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Skill;

class PostControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseTransactions;
    
    public function testExample()
    {
        //PostControllerにおけるルーティングテスト
        //未認証または認証済みでviewの出し分けが出来ているか確認
        //未認証の場合
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertViewIs('top')
            ->assertTitle('ShareMyLearning')
            ->assertSee('積み重ねの記録を残そう');

        //認証済みの場合
        $user = factory(User::class)->create();

        $response = $this
            ->actingAs($user)
            ->get('/');

        $response->assertStatus(200)
            ->assertViewIs('main')
            ->assertCookie('XSRF-TOKEN')
            ->assertCookie('laravel_session')
            ->assertTitle('ShareMyLearning')
            ->assertSee('検索')
            ->assertSee('投稿する')
            ->assertSee($user->name);
    }
}
