<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AccessTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseTransactions;

    //未認証ユーザーのアクセス
    public function testAccess()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get(route('mypage'));
        $response->assertStatus(302);

        $response = $this->get(route('mypage.edit'));
        $response->assertStatus(302);

        $response = $this->post(route('mypage.update'));
        $response->assertStatus(302);

        $response = $this->post(route('user.delete'));
        $response->assertStatus(302);

        $response = $this->post(route('post.create'));
        $response->assertStatus(302);

        $response = $this->post(route('post.getid'));
        $response->assertStatus(302);

        $response = $this->post(route('post.attach'));
        $response->assertStatus(302);

        $response = $this->post(route('post.detach'));
        $response->assertStatus(302);

        $response = $this->post(route('post.edit'));
        $response->assertStatus(302);

        $response = $this->get(route('talk', ['id' => 1]));
        $response->assertStatus(302);

        $response = $this->post(route('talk.create'));
        $response->assertStatus(302);

        $response = $this->post(route('talk.delete', ['id' => 1]));
        $response->assertStatus(302);

        $response = $this->get(route('search'));
        $response->assertStatus(302);

        $response = $this->get(route('userpage', ['id' => 1]));
        $response->assertStatus(302);

    }

    //認証済みユーザーのアクセス
    public function testAuthAccess()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('mypage'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('mypage.edit'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post(route('mypage.update'));
        $response->assertStatus(302);

        $response = $this->actingAs($user)->post(route('user.delete'));
        $response->assertStatus(302);

        $response = $this->actingAs($user)->post(route('post.create'));
        $response->assertStatus(302);
        
        $response = $this->actingAs($user)->get(route('talk', ['id' => 1]));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post(route('talk.create'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post(route('talk.delete', ['id' => 1]));
        $response->assertStatus(302);

        $response = $this->actingAs($user)->post(route('post.getid'));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->post(route('post.edit'));
        $response->assertStatus(302);

        $response = $this->actingAs($user)->post(route('post.delete', ['id' => 1]));
        $response->assertStatus(302);

        $response = $this->actingAs($user)->get(route('userpage', ['id' => 1]));
        $response->assertStatus(200);

        $response = $this->actingAs($user)->get(route('search'));
        $response->assertStatus(200);

    }
}
