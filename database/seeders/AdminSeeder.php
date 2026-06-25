<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Create 3 admin accounts
        DB::table('admins')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@realestate.com',
                'password' => Hash::make('12345678'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Property Manager',
                'email' => 'manager@realestate.com',
                'password' => Hash::make('12345678'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'System Administrator',
                'email' => 'sysadmin@realestate.com',
                'password' => Hash::make('12345678'),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}