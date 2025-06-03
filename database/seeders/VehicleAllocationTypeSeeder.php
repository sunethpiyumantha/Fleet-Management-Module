<?php
namespace Database\Seeders;
use App\Models\VehicleAllocationType;
use Illuminate\Database\Seeder;
class VehicleAllocationTypeSeeder extends Seeder
{
    public function run()
    {
        $types = ['Admin Duties', 'Staff Car', 'Emergency Support', 'Event Vehicle'];
        foreach ($types as $type) {
            VehicleAllocationType::create(['type' => $type]);
        }
    }
}