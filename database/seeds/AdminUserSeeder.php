<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Griffith Lockhart',
            'email' => 'grifithora@gmail.com',
            'password' => Hash::make('admin'),
            'user_type' => 1,
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
