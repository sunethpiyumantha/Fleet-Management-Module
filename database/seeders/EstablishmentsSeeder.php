<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstablishmentsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['e_id' => 1, 'name' => 'Sri Lanka Army', 'abb_name' => 'SL ARMY', 'type_code' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['e_id' => 2, 'name' => "Commander's Secretariat", 'abb_name' => "Comd's Sec", 'type_code' => 32, 'created_at' => now(), 'updated_at' => now()],
            // Add all ~1090 records, cleaning special characters
            ['e_id' => 1090, 'name' => 'Uva Wellassa University Of Sri Lanka', 'abb_name' => 'Uva Wellassa University Of Sri Lanka', 'type_code' => 30, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('establishments')->insert($chunk);
        }
    }
}