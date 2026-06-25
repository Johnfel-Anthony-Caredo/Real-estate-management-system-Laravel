<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('ALTER TABLE props AUTO_INCREMENT = 1');

        $now = Carbon::now();
        $description = 'A carefully maintained property with bright living spaces, practical storage, secure access, and excellent proximity to schools, retail, transport, and daily essentials. This listing is prepared for portfolio demonstration with realistic property details and clean presentation copy.';

        DB::table('props')->insert([
            [
                'id' => 1,
                'title' => 'Avida Cityview Condo',
                'price' => '4400000',
                'image' => 'hero_bg_1.jpg',
                'beds' => '2',
                'baths' => '2',
                'sq_ft' => '860',
                'home_type' => 'Condo',
                'year_built' => '2019',
                'price_sqft' => '5116',
                'more_info' => $description,
                'location' => 'Davao City, Philippines',
                'agent_name' => 'Mara Santos',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'title' => 'Palm Grove Family House',
                'price' => '7200000',
                'image' => 'hero_bg_2.jpg',
                'beds' => '4',
                'baths' => '3',
                'sq_ft' => '2400',
                'home_type' => 'House',
                'year_built' => '2021',
                'price_sqft' => '3000',
                'more_info' => $description,
                'location' => 'Tagum City, Philippines',
                'agent_name' => 'Luis Rivera',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'title' => 'Northpoint Executive Villa',
                'price' => '18500000',
                'image' => 'hero_bg_4.jpg',
                'beds' => '5',
                'baths' => '5',
                'sq_ft' => '5200',
                'home_type' => 'Villa',
                'year_built' => '2022',
                'price_sqft' => '3558',
                'more_info' => $description,
                'location' => 'Panabo City, Philippines',
                'agent_name' => 'Andrea Lim',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'title' => 'Greenlane Townhouse',
                'price' => '5800000',
                'image' => '1745941300.jpg',
                'beds' => '3',
                'baths' => '3',
                'sq_ft' => '1680',
                'home_type' => 'Townhouse',
                'year_built' => '2020',
                'price_sqft' => '3452',
                'more_info' => $description,
                'location' => 'Davao City, Philippines',
                'agent_name' => 'Paolo Mercado',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 5,
                'title' => 'Hillcrest Modern House',
                'price' => '9600000',
                'image' => '1745941440.jpg',
                'beds' => '4',
                'baths' => '4',
                'sq_ft' => '3100',
                'home_type' => 'House',
                'year_built' => '2023',
                'price_sqft' => '3097',
                'more_info' => $description,
                'location' => 'Panabo City, Philippines',
                'agent_name' => 'Nina Tan',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 6,
                'title' => 'Riverside Premium Condo',
                'price' => '6200000',
                'image' => '1745941550.jpg',
                'beds' => '3',
                'baths' => '2',
                'sq_ft' => '1180',
                'home_type' => 'Condo',
                'year_built' => '2022',
                'price_sqft' => '5254',
                'more_info' => $description,
                'location' => 'Tagum City, Philippines',
                'agent_name' => 'Carlo Reyes',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
