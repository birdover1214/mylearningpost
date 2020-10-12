<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => '山田太郎',
                'email' => 'yamada@google.com',
                'password' => Hash::make('password'),
            ],

            [
                'name' => '田中花子',
                'email' => 'hanako@google.com',
                'password' => Hash::make('password'),
            ],

            [
                'name' => 'Ryo',
                'email' => 'ryo@google.com',
                'password' => Hash::make('password'),
            ],

            [
                'name' => 'suzu',
                'email' => 'suzu@google.com',
                'password' => Hash::make('password'),
            ],

            [
                'name' => 'しゅーへい',
                'email' => 'syuhei@google.com',
                'password' => Hash::make('password'),
            ],
        ]);
    }
}
