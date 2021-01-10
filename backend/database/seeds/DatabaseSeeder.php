<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(SkillsTableSeeder::class);

        $skills = App\Models\Skill::all();

        $this->call([
            UsersTableSeeder::class,
            AdminsTableSeeder::class,
            ]);

        App\Models\User::all()->each(function ($user) use ($skills) {
            $user->skills()->attach($skills->random(rand(1,10))->pluck('id')->toArray());
        });

        $this->call(PostsTableSeeder::class);
        //$this->call(PostsTableSeeder::class);
    }
}
