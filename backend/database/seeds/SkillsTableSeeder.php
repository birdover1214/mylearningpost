<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            ['skill_name' => 'AngularJS'],
            ['skill_name' => 'AWS'],
            ['skill_name' => 'C'],
            ['skill_name' => 'C#'],
            ['skill_name' => 'C++'],
            ['skill_name' => 'CakePHP'],
            ['skill_name' => 'CSS'],
            ['skill_name' => 'Django'],
            ['skill_name' => 'Docker'],
            ['skill_name' => 'ExpressJS'],
            ['skill_name' => 'Git'],
            ['skill_name' => 'Go'],
            ['skill_name' => 'HTML'],
            ['skill_name' => 'Java'],
            ['skill_name' => 'JavaScript'],
            ['skill_name' => 'jQuery'],
            ['skill_name' => 'Kotlin'],
            ['skill_name' => 'Laravel'],
            ['skill_name' => 'PHP'],
            ['skill_name' => 'Python'],
            ['skill_name' => 'R'],
            ['skill_name' => 'React'],
            ['skill_name' => 'Ruby'],
            ['skill_name' => 'Ruby on Rails'],
            ['skill_name' => 'Scala'],
            ['skill_name' => 'Spark'],
            ['skill_name' => 'Spring'],
            ['skill_name' => 'Swift'],
            ['skill_name' => 'VisualBasic'],
            ['skill_name' => 'Vue.js'],
            ['skill_name' => 'WordPress'],
        ]);
    }
}
