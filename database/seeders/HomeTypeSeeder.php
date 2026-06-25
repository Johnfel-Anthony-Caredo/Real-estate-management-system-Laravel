<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeTypeSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('hometypes')->insert([
            ['id' => 1, 'hometypes' => 'Condo', 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['id' => 2, 'hometypes' => 'House', 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['id' => 3, 'hometypes' => 'Townhouse', 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
            ['id' => 4, 'hometypes' => 'Villa', 'created_at' => $now, 'updated_at' => $now, 'deleted_at' => null],
        ]);
    }
}
