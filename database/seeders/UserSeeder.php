<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Carbon\Carbon;
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
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => UserRole::ADMIN,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Store1',
                'email' => 'store1@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => UserRole::STORE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Store2',
                'email' => 'store2@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => UserRole::STORE,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Staff1',
                'email' => 'staff1@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => UserRole::STAFF,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Staff2',
                'email' => 'staff2@gmail.com',
                'password' => Hash::make('123123123'),
                'role' => UserRole::STAFF,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
