<?php

namespace Database\Seeders;

use App\Models\AdminUser\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AdminUser::truncate();
        AdminUser::create([
            'first_name' => 'Admin',
            'last_name' => 'Futech',
            'email' => 'admin@futechnepal.com',
            'user_type' => 'admin',
            'is_active' => 1,
            'password' => Hash::make('Forgot911!'),
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
