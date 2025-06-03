<?php
namespace Database\Seeders;
use App\Models\VehicleCategory;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Light Vehicle', 'Motor Vehicle', 'Heavy Vehicle', 'Off-Road Vehicle'];
        foreach ($categories as $category) {
            VehicleCategory::create(['category' => $category]);
        }
    }
}