<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleCategory;
use App\Models\VehicleSubCategory;
use App\Models\VehicleRequest;

class VehicleCategorySeeder extends Seeder
{
    public function run()
    {
        $category1 = VehicleCategory::create(['category' => 'Car']);
        $subCategory1 = VehicleSubCategory::create(['cat_id' => $category1->id, 'sub_category' => 'Sedan']);
        VehicleRequest::create([
            'cat_id' => $category1->id,
            'sub_cat_id' => $subCategory1->id,
            'qty' => 1,
            'date_submit' => now(),
            'status' => 'pending',
        ]);
    }
}