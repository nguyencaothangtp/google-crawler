<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'email' => 'admin@gmail.com',
            'name' => 'Nguyễn Cao Thắng',
            'password' => Hash::make('123456'),
        ]);
    }
}
