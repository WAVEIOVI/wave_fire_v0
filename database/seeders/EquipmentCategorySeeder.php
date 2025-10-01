<?php

namespace Database\Seeders;

use App\Models\EquipmentCategory;
use App\Models\EquipmentModel;
use Illuminate\Database\Seeder;

class EquipmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create categories
        $categories = [
            ['category_id' => 'CA001', 'name' => 'fire extinguisher'],
            ['category_id' => 'CA002', 'name' => 'fire hose'],
        ];

        foreach ($categories as $category) {
            EquipmentCategory::firstOrCreate(['category_id' => $category['category_id']], $category);
        }

        // Create models for 'fire extinguisher' category
        $fireExtinguisherCategory = EquipmentCategory::where('category_id', 'CA001')->first();
        $fireExtinguisherModels = [
            ['model_category_id' => 'CA001', 'category_name' => 'fire extinguisher', 'model_id' => 'MD001', 'name' => 'water-based'],
            ['model_category_id' => 'CA001', 'category_name' => 'fire extinguisher', 'model_id' => 'MD002', 'name' => 'powder abc'],
            ['model_category_id' => 'CA001', 'category_name' => 'fire extinguisher', 'model_id' => 'MD003', 'name' => 'co2'],
            ['model_category_id' => 'CA001', 'category_name' => 'fire extinguisher', 'model_id' => 'MD004', 'name' => 'foam'],
            ['model_category_id' => 'CA001', 'category_name' => 'fire extinguisher', 'model_id' => 'MD005', 'name' => 'wet chemical'],
            ['model_category_id' => 'CA001', 'category_name' => 'fire extinguisher', 'model_id' => 'MD006', 'name' => 'dry powder'],
        ];

        foreach ($fireExtinguisherModels as $model) {
            EquipmentModel::firstOrCreate(['model_id' => $model['model_id']], $model);
        }

        // Create models for 'fire hose' category
        $fireHoseCategory = EquipmentCategory::where('category_id', 'CA002')->first();
        $fireHoseModels = [
            ['model_category_id' => 'CA002', 'category_name' => 'fire hose', 'model_id' => 'MD007', 'name' => 'dn 19'],
            ['model_category_id' => 'CA002', 'category_name' => 'fire hose', 'model_id' => 'MD008', 'name' => 'dn 25'],
            ['model_category_id' => 'CA002', 'category_name' => 'fire hose', 'model_id' => 'MD009', 'name' => 'dn 33'],
        ];

        foreach ($fireHoseModels as $model) {
            EquipmentModel::firstOrCreate(['model_id' => $model['model_id']], $model);
        }
    }
}
