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

        if (!filter_var(env('SEED_DEMO_ADMIN', false), FILTER_VALIDATE_BOOLEAN)) {
            $this->command?->warn('Skipped admin seeding. Set SEED_DEMO_ADMIN=true for a local demo admin.');
            return;
        }

        $password = env('DEMO_ADMIN_PASSWORD');

        if (!$password || strlen($password) < 12) {
            $this->command?->warn('Skipped admin seeding. DEMO_ADMIN_PASSWORD must be at least 12 characters.');
            return;
        }

        DB::table('admins')->updateOrInsert(
            ['email' => env('DEMO_ADMIN_EMAIL', 'admin@example.test')],
            [
                'name' => env('DEMO_ADMIN_NAME', 'Demo Admin'),
                'password' => Hash::make($password),
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
