<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('ALTER TABLE prop_image AUTO_INCREMENT = 1');

        $now = Carbon::now();

        DB::table('prop_image')->insert([
            ['id' => 1, 'prop_id' => 1, 'image' => 'gallery_1746570769_2258.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'prop_id' => 1, 'image' => 'gallery_1746570769_2234.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'prop_id' => 2, 'image' => 'gallery_1746570800_7410.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'prop_id' => 2, 'image' => 'gallery_1746570800_6100.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'prop_id' => 3, 'image' => 'gallery_1746570818_8652.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'prop_id' => 3, 'image' => 'gallery_1746570818_6470.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'prop_id' => 4, 'image' => 'gallery_1745941300_0_4393.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'prop_id' => 4, 'image' => 'gallery_1745941440_0_5459.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9, 'prop_id' => 5, 'image' => 'gallery_1747291393_0_9955.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'prop_id' => 5, 'image' => 'gallery_1747291393_1_1648.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 11, 'prop_id' => 6, 'image' => 'gallery_1745941550_0_7909.jpg', 'created_at' => $now, 'updated_at' => $now],
            ['id' => 12, 'prop_id' => 6, 'image' => 'gallery_1745942475_3687.jpg', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
