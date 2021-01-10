<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Skill;
use App\Models\Talk;

class DatabaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseTransactions;

    public function testDatabase()
    {
        //各テーブルに指定のカラムを持っているかテスト
        //users
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id', 'name', 'email', 'password', 'introduction', 'user_image', 'created_at', 'updated_at'
            ]),
            1
        );

        //admins
        $this->assertTrue(
            Schema::hasColumns('admins',[
                'id', 'name', 'password', 'created_at', 'updated_at'
            ]),
            1
        );

        //posts
        $this->assertTrue(
            Schema::hasColumns('posts', [
                'id', 'user_id', 'skill_id', 'time', 'comment', 'created_at', 'updated_at'
            ]),
            1
        );

        //skills
        $this->assertTrue(
            Schema::hasColumns('skills', [
                'id', 'skill_name', 'created_at', 'updated_at'
            ]),
            1
        );

        //talks
        $this->assertTrue(
            Schema::hasColumns('talks', [
                'id', 'user_id', 'comment', 'created_at', 'updated_at'
            ]),
            1
        );

        //post_user
        $this->assertTrue(
            Schema::hasColumns('post_user', [
                'id', 'user_id', 'post_id'
            ]),
            1
        );

        //skill_user
        $this->assertTrue(
            Schema::hasColumns('skill_user', [
                'id', 'user_id', 'skill_id'
            ]),
            1
        );
    }

    public function testCreateDatabase()
    {
        //各テーブルにデータを登録できるかテスト
        //users
        $user = new User();
        $user->name = 'testuser';
        $user->email = 'testuser@example.com';
        $user->password = Hash::make('password');
        $user->introduction = 'introductiontest';
        $saveUser = $user->save();

        $this->assertTrue($saveUser);

        //posts
        $post = new Post();
        $post->user_id = 1;
        $post->skill_id = 1;
        $post->time = 1;
        $post->comment = 'postcomment';
        $savePost = $post->save();

        $this->assertTrue($savePost);

        //skills
        $skill = new Skill();
        $skill->skill_name = 'skill';
        $saveSkill = $skill->save();

        $this->assertTrue($saveSkill);

        //talk
        $talk = new Talk();
        $talk->user_id = 1;
        $talk->post_id = 1;
        $talk->comment = 'talkcomment';
        $saveTalk = $talk->save();

        $this->assertTrue($saveTalk);

        //skill_user
        $skillUser = $user->skills()->attach(1);

        $this->assertNull($skillUser);

        //post_user
        $postUser = $user->favorites()->attach(1);

        $this->assertNull($postUser);
    }
}
