<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->truncate();
        DB::table('admin_users')->insert([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@futechnepal.com',
            'user_type' => 'admin',
            'is_active' => 1,
            'password' => Hash::make('Forgot911!'),
        ]);
    }
}
