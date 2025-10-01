<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RecapMissionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total_equipment' => $this->collection->count(),
                'total_fire_extinguishers' => $this->collection->where('equipment_category', 'fire extinguisher')->count(),
                'total_fire_hoses' => $this->collection->where('equipment_category', 'fire hose')->count(),
                'total_others_equipment' => $this->collection->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])->count(),
                'total_equipment_by_category' => $this->collection
                    ->groupBy('equipment_category')
                    ->map->count(),
                'total_fire_extinguishers_by_model' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->groupBy('equipment_model')
                    ->map->count(),

                'total_equipment_in_service' => $this->collection->where('pivot.equipment_status', 'in service')->count(),
                'total_equipment_limited_use' => $this->collection->where('pivot.equipment_status', 'limited use')->count(),
                'total_equipment_out_of_service' => $this->collection->where('pivot.equipment_status', 'out of order')->count(),

                'equipment_by_status' => $this->collection
                    ->groupBy(function ($item) {
                        return $item['pivot']['equipment_status'];
                    })
                    ->map->count(),
                'fire_extinguisher_by_status' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->groupBy(function ($item) {
                        return $item['equipment_category'] . ' ' . $item['equipment_model'] . ' ' . $item['equipment_pressure'] . ' ' . $item['equipment_weight_value'] . ' ' . $item['equipment_weight_unit'] . ' ' . $item['pivot']['equipment_status'];
                    })
                    ->map->count(),
                'fire_hose_by_status' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->groupBy(function ($item) {
                        return $item['equipment_category'] . ' ' . $item['equipment_model'] . ' ' . $item['pivot']['equipment_status'];
                    })
                    ->map->count(),

                'others_equipment_by_status' => $this->collection
                    ->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])
                    ->groupBy(function ($item) {
                        return $item['equipment_category'] . ' ' . $item['equipment_model'] . ' ' . $item['pivot']['equipment_status'];
                    })
                    ->map->count(),

                'protection_by_equipment' => $this->collection
                    ->groupBy(function ($item) {
                        $name = $item['pivot']['equipment_protection_name'];
                        return is_null($name) ? 'none' : ($name === '' ? 'none' : $name);
                    })
                    ->map->count()
                    ->filter(function ($count, $key) {
                        return $key !== 'none';
                    }),
                'protection_by_fire_extinguisher' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->filter(function ($item) {
                        $name = $item['pivot']['equipment_protection_name'];
                        return !is_null($name) && $name !== '' && $name !== 'none';
                    })
                    ->groupBy(function ($item) {
                        $name = $item['pivot']['equipment_protection_name'];
                        $category = $item['equipment_category'];
                        $model = $item['equipment_model'];
                        $weight = $item['equipment_weight_value'];
                        $unit = $item['equipment_weight_unit'];

                        return "$name $category $model $weight $unit";
                    })
                    ->map->count(),

                'protection_fire_hose_by_model' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->filter(function ($item) {
                        $name = $item['pivot']['equipment_protection_name'];
                        return !is_null($name) && $name !== '' && $name !== 'none';
                    })
                    ->groupBy(function ($item) {
                        $name = $item['pivot']['equipment_protection_name'];
                        $category = $item['equipment_category'];
                        $model = $item['equipment_model'];

                        return "$name $category $model";
                    })
                    ->map->count(),

                'protection_others_equipment_by_model' => $this->collection
                    ->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])
                    ->filter(function ($item) {
                        $name = $item['pivot']['equipment_protection_name'];
                        return !is_null($name) && $name !== '' && $name !== 'none';
                    })
                    ->groupBy(function ($item) {
                        $name = $item['pivot']['equipment_protection_name'];
                        $category = $item['equipment_category'];
                        $model = $item['equipment_model'];
                        $weight = $item['equipment_weight_value'];
                        $unit = $item['equipment_weight_unit'];


                        return "$name $category $model $weight $unit";
                    })
                    ->map->count(),

                'inspected_equipment' => $this->collection
                    ->where('pivot.inspection', 'inspected')
                    ->count(),
                'inspected_fire_extinguisher' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.inspection', 'inspected')
                    ->count(),
                'inspected_fire_hose' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.inspection', 'inspected')
                    ->count(),
                'inspected_others_equipment' => $this->collection
                    ->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])
                    ->where('pivot.inspection', 'inspected')
                    ->count(),

                'inspected_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.inspection', 'inspected')
                    ->groupBy(function ($item) {
                        return $item['equipment_category'] . ' ' . $item['equipment_model'] . ' ' . $item['equipment_pressure'] . ' ' . $item['equipment_weight_value'] . ' ' . $item['equipment_weight_unit'];
                    })
                    ->map->count(),
                'inspected_fire_hose_by_model' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.inspection', 'inspected')
                    ->groupBy(function ($item) {
                        return $item['equipment_category'] . ' ' . $item['equipment_model'];
                    })
                    ->map->count(),
                'inspected_others_equipment_by_model' => $this->collection
                    ->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])
                    ->where('pivot.inspection', 'inspected')
                    ->groupBy(function ($item) {
                        return $item['equipment_category'] . ' ' . $item['equipment_model'];
                    })
                    ->map->count(),

                'out_of_orderby_qrc_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.equipment_status', 'out of order')
                    ->groupBy(function ($item) {
                        return $item['qrc_id'] . ' - ' . $item['internal_id'] . ' | ' . $item['equipment_category'] . ' ' . $item['equipment_model'] . ' ' . $item['equipment_pressure'] . ' ' . $item['equipment_weight_value'] . ' ' . $item['equipment_weight_unit'];
                    })
                    ->map->count(),
                'out_of_order_fire_extinguisher_by_qrc_model_weight' => $this->collection
                    ->where('pivot.equipment_status', 'out of order')
                    ->groupBy(function ($item) {
                        return $item['qrc_id'] . ' - ' . $item['internal_id'] . ' | ' . $item['equipment_category'] . ' ' . $item['equipment_model'] . ' ' . $item['equipment_pressure'] . ' ' . $item['equipment_weight_value'] . ' ' . $item['equipment_weight_unit'];
                    })
                    ->map->count(),
                'out_of_order_fire_hose_by_qrc_model' => $this->collection
                    ->where('equipment_category', 'fire hose')
                    ->where('pivot.equipment_status', 'out of order')
                    ->groupBy(function ($item) {
                        return $item['qrc_id'] . ' - ' . $item['internal_id'] . ' | ' . $item['equipment_category'] . ' ' . $item['equipment_model'];
                    })
                    ->map->count(),

                'out_of_order_others_equipment_by_qrc_model' => $this->collection
                    ->whereNotIn('equipment_category', ['fire extinguisher', 'fire hose'])
                    ->where('pivot.equipment_status', 'out of order')
                    ->groupBy(function ($item) {
                        return $item['qrc_id'] . ' - ' . $item['internal_id'] . ' | ' . $item['equipment_category'] . ' ' . $item['equipment_model'];
                    })
                    ->map->count(),

                'raw_recharged_fire_extinguisher_count' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.raw_recharge', 'raw charged')
                    ->count(),
                'raw_recharged_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.raw_recharge', 'raw charged')
                    ->groupBy(function ($item) {
                        return $item['equipment_category'] . ' ' . $item['equipment_model'] . ' ' . $item['equipment_pressure'] . ' ' . $item['equipment_weight_value'] . ' ' . $item['equipment_weight_unit'];
                    })
                    ->map->count(),

                'nitrogen_recharged_fire_extinguisher_count' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('equipment_pressure', 'permanent pressure')
                    ->where('pivot.nitrogen_recharge', 'nitrogen charged')
                    ->count(),
                'recharged_sparklet_count' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('equipment_pressure', 'auxiliary pressure')
                    ->where('pivot.nitrogen_recharge', 'nitrogen charged')
                    ->count(),
                'nitrogen_recharged_fire_extinguisher_by_model_weight' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.nitrogen_recharge', 'nitrogen charged')
                    ->groupBy(function ($item) {
                        return $item['equipment_category'] . ' ' . $item['equipment_model'] . ' ' . $item['equipment_pressure'] . ' ' . $item['equipment_weight_value'] . ' ' . $item['equipment_weight_unit'];
                    })
                    ->map->count(),

                'accessory_counts' => $this->getAccessoryCounts(),
                'accessory_fire_extinguisher_counts' => $this->getAccessoryFireExtinguisherCounts(),
                'accessory_fire_hose_counts' => $this->getAccessoryFireHoseCounts(),
                'accessory_others_equipment_counts' => $this->getAccessoryOthersEquipmentCounts(),

                'supply_counts' => $this->getSupplyCounts(),
                'supply_fire_extinguisher_counts' => $this->getSupplyFireExtinguisherCounts(),
                'supply_fire_hose_counts' => $this->getSupplyFireHoseCounts(),
                'supply_others_equipment_counts' => $this->getSupplyOthersEquipmentCounts(),

                'maintenance_counts' => $this->getMaintenanceCounts(),
                'maintenance_fire_extinguisher_counts' => $this->getMaintenanceFireExtinguisherCounts(),
                'maintenance_fire_hose_counts' => $this->getMaintenanceFireHoseCounts(),
                'maintenance_others_equipment_counts' => $this->getMaintenanceOthersEquipmentCounts(),

                'additional_maintenance_counts' => $this->getAdditionalMaintenanceCounts(),
                'additional_maintenance_fire_extinguisher_counts' => $this->getAdditionalMaintenanceFireExtinguisherCounts(),
                'additional_maintenance_fire_hose_counts' => $this->getAdditionalMaintenanceFireHoseCounts(),
                'additional_maintenance_others_equipment_counts' => $this->getAdditionalMaintenanceOthersEquipmentCounts(),

                'total_raw_material_for_fire_extinguishers' => $this->collection
                    ->where('equipment_category', 'fire extinguisher')
                    ->where('pivot.raw_recharge', 'raw charged')
                    ->groupBy(function ($item) {
                        return explode(' ', $item['equipment_model'])[0];
                    })
                    ->map(function ($items) {
                        // Sum the numerical values of equipment_weight_value
                        $totalWeight = $items->sum(function ($item) {
                            return (float)$item['equipment_weight_value'];
                        });

                        // Assume all items have the same unit
                        $unit = $items->first()['equipment_weight_unit'];

                        return $totalWeight . ' ' . $unit;
                    })
                    ->toArray(),
            ],
        ];
    }

    protected function getMaintenanceCounts()
    {
        $maintenanceCounts = [];

        // Iterate over each item in maintenance field and count occurrences
        $this->collection->each(function ($item) use (&$maintenanceCounts) {
            $maintenance = []; // Initialize with empty array

            if (isset($item['pivot']['maintenance']) && !empty($item['pivot']['maintenance'])) {
                $decodedMaintenance = json_decode($item['pivot']['maintenance'], true);
                if (is_array($decodedMaintenance)) {
                    $maintenance = $decodedMaintenance; // Use decoded array only if valid
                } else {
                    // Handle invalid JSON (log error, set default value)
                    error_log("Invalid JSON data in 'maintenance' field for item: " . $item['id']);
                }
            }

            // Process the $maintenance array (now guaranteed to be an array)
            foreach ($maintenance as $activity) {
                if (isset($maintenanceCounts[$activity])) {
                    $maintenanceCounts[$activity]++;
                } else {
                    $maintenanceCounts[$activity] = 1;
                }
            }
        });

        return $maintenanceCounts;
    }

    protected function getMaintenanceFireExtinguisherCounts()
    {
        $maintenanceCounts = [];

        // Iterate over each item in maintenance field
        $this->collection->each(function ($item) use (&$maintenanceCounts) {
            $maintenance = []; // Initialize with empty array

            if ($item['equipment_category'] === 'fire extinguisher') {
                if (isset($item['pivot']['maintenance']) && !empty($item['pivot']['maintenance'])) {
                    $decodedMaintenance = json_decode($item['pivot']['maintenance'], true);
                    if (is_array($decodedMaintenance)) {
                        $maintenance = $decodedMaintenance; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'maintenance' field for item: " . $item['id']);
                    }
                }

                // Process the $maintenance array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];
                $pressure = $item['equipment_pressure'];
                $weightValue = $item['equipment_weight_value'];
                $weightUnit = $item['equipment_weight_unit'];

                foreach ($maintenance as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' ' . $pressure . ' ' . $weightValue . ' ' . $weightUnit . ' : ' . $activity;
                    $maintenanceCounts[$key] = isset($maintenanceCounts[$key]) ? $maintenanceCounts[$key] + 1 : 1;
                }
            }
        });

        return $maintenanceCounts;
    }

    protected function getMaintenanceFireHoseCounts()
    {
        $maintenanceCounts = [];

        // Iterate over each item in maintenance field
        $this->collection->each(function ($item) use (&$maintenanceCounts) {
            $maintenance = []; // Initialize with empty array

            if ($item['equipment_category'] === 'fire hose') {
                if (isset($item['pivot']['maintenance']) && !empty($item['pivot']['maintenance'])) {
                    $decodedMaintenance = json_decode($item['pivot']['maintenance'], true);
                    if (is_array($decodedMaintenance)) {
                        $maintenance = $decodedMaintenance; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'maintenance' field for item: " . $item['id']);
                    }
                }

                // Process the $maintenance array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];

                foreach ($maintenance as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' ' . $activity;
                    $maintenanceCounts[$key] = isset($maintenanceCounts[$key]) ? $maintenanceCounts[$key] + 1 : 1;
                }
            }
        });

        return $maintenanceCounts;
    }

    protected function getMaintenanceOthersEquipmentCounts()
    {
        $maintenanceCounts = [];

        // Iterate over each item in maintenance field
        $this->collection->each(function ($item) use (&$maintenanceCounts) {
            $category = $item['equipment_category'];

            // Check if the category is not 'fire hose' or 'fire extinguisher'
            if ($category !== 'fire hose' && $category !== 'fire extinguisher') {
                $maintenance = []; // Initialize with empty array

                if (isset($item['pivot']['maintenance']) && !empty($item['pivot']['maintenance'])) {
                    $decodedMaintenance = json_decode($item['pivot']['maintenance'], true);
                    if (is_array($decodedMaintenance)) {
                        $maintenance = $decodedMaintenance; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'maintenance' field for item: " . $item['id']);
                    }
                }

                // Process the $maintenance array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];
                $pressure = $item['equipment_pressure'];
                $weightValue = $item['equipment_weight_value'];
                $weightUnit = $item['equipment_weight_unit'];

                foreach ($maintenance as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' ' . $pressure . ' ' . $weightValue . ' ' . $weightUnit . ' : ' . $activity;
                    $maintenanceCounts[$key] = isset($maintenanceCounts[$key]) ? $maintenanceCounts[$key] + 1 : 1;
                }
            }
        });

        return $maintenanceCounts;
    }

    protected function getAdditionalMaintenanceCounts()
    {
        $additionalMaintenanceCounts = [];

        // Iterate over each item in additionalMaintenance field
        $this->collection->each(function ($item) use (&$additionalMaintenanceCounts) {
            $additionalMaintenance = []; // Initialize with empty array

            if (isset($item['pivot']['additional_maintenance']) && !empty($item['pivot']['additional_maintenance'])) {
                $decodedAdditionalMaintenance = json_decode($item['pivot']['additional_maintenance'], true);
                if (is_array($decodedAdditionalMaintenance)) {
                    $additionalMaintenance = $decodedAdditionalMaintenance; // Use decoded array only if valid
                } else {
                    // Handle invalid JSON (log error, set default value)
                    error_log("Invalid JSON data in 'additional_maintenance' field for item: " . $item['id']);
                }
            }

            // Process the $additionalMaintenance array (now guaranteed to be an array)
            foreach ($additionalMaintenance as $activity) {
                if (isset($additionalMaintenanceCounts[$activity])) {
                    $additionalMaintenanceCounts[$activity]++;
                } else {
                    $additionalMaintenanceCounts[$activity] = 1;
                }
            }
        });

        return $additionalMaintenanceCounts;
    }

    protected function getAdditionalMaintenanceFireExtinguisherCounts()
    {
        $additionalMaintenanceCounts = [];

        // Iterate over each item in additionalMaintenance field
        $this->collection->each(function ($item) use (&$additionalMaintenanceCounts) {
            $additionalMaintenance = []; // Initialize with empty array

            if ($item['equipment_category'] === 'fire extinguisher') {
                if (isset($item['pivot']['additional_maintenance']) && !empty($item['pivot']['additional_maintenance'])) {
                    $decodedAdditionalMaintenance = json_decode($item['pivot']['additional_maintenance'], true);
                    if (is_array($decodedAdditionalMaintenance)) {
                        $additionalMaintenance = $decodedAdditionalMaintenance; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'additional_maintenance' field for item: " . $item['id']);
                    }
                }

                // Process the $additionalMaintenance array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];
                $pressure = $item['equipment_pressure'];
                $weightValue = $item['equipment_weight_value'];
                $weightUnit = $item['equipment_weight_unit'];

                foreach ($additionalMaintenance as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' ' . $pressure . ' ' . $weightValue . ' ' . $weightUnit . ' : ' . $activity;
                    $additionalMaintenanceCounts[$key] = isset($additionalMaintenanceCounts[$key]) ? $additionalMaintenanceCounts[$key] + 1 : 1;
                }
            }
        });

        return $additionalMaintenanceCounts;
    }

    protected function getAdditionalMaintenanceFireHoseCounts()
    {
        $additionalMaintenanceCounts = [];

        // Iterate over each item in additionalMaintenance field
        $this->collection->each(function ($item) use (&$additionalMaintenanceCounts) {
            $additionalMaintenance = []; // Initialize with empty array

            if ($item['equipment_category'] === 'fire hose') {
                if (isset($item['pivot']['additional_maintenance']) && !empty($item['pivot']['additional_maintenance'])) {
                    $decodedAdditionalMaintenance = json_decode($item['pivot']['additional_maintenance'], true);
                    if (is_array($decodedAdditionalMaintenance)) {
                        $additionalMaintenance = $decodedAdditionalMaintenance; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'additional_maintenance' field for item: " . $item['id']);
                    }
                }

                // Process the $additionalMaintenance array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];

                foreach ($additionalMaintenance as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' : ' . $activity;
                    $additionalMaintenanceCounts[$key] = isset($additionalMaintenanceCounts[$key]) ? $additionalMaintenanceCounts[$key] + 1 : 1;
                }
            }
        });

        return $additionalMaintenanceCounts;
    }

    protected function getAdditionalMaintenanceOthersEquipmentCounts()
    {
        $additionalMaintenanceCounts = [];

        // Iterate over each item in additionalMaintenance field
        $this->collection->each(function ($item) use (&$additionalMaintenanceCounts) {
            $category = $item['equipment_category'];

            // Check if the category is not 'fire hose' or 'fire extinguisher'
            if ($category !== 'fire hose' && $category !== 'fire extinguisher') {
                $additionalMaintenance = []; // Initialize with empty array

                if (isset($item['pivot']['additional_maintenance']) && !empty($item['pivot']['additional_maintenance'])) {
                    $decodedAdditionalMaintenance = json_decode($item['pivot']['additional_maintenance'], true);
                    if (is_array($decodedAdditionalMaintenance)) {
                        $additionalMaintenance = $decodedAdditionalMaintenance; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'additional_maintenance' field for item: " . $item['id']);
                    }
                }

                // Process the $additionalMaintenance array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];
                $pressure = $item['equipment_pressure'];
                $weightValue = $item['equipment_weight_value'];
                $weightUnit = $item['equipment_weight_unit'];

                foreach ($additionalMaintenance as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' ' . $pressure . ' ' . $weightValue . ' ' . $weightUnit . ' : ' . $activity;
                    $additionalMaintenanceCounts[$key] = isset($additionalMaintenanceCounts[$key]) ? $additionalMaintenanceCounts[$key] + 1 : 1;
                }
            }
        });

        return $additionalMaintenanceCounts;
    }

    protected function getAccessoryCounts()
    {
        $accessoryCounts = [];

        // Iterate over each item in accessory field
        $this->collection->each(function ($item) use (&$accessoryCounts) {
            $accessory = []; // Initialize with empty array

            if (isset($item['pivot']['accessory']) && !empty($item['pivot']['accessory'])) {
                $decodedAccessory = json_decode($item['pivot']['accessory'], true);
                if (is_array($decodedAccessory)) {
                    $accessory = $decodedAccessory; // Use decoded array only if valid
                } else {
                    // Handle invalid JSON (log error, set default value)
                    error_log("Invalid JSON data in 'accessory' field for item: " . $item['id']);
                }
            }

            // Process the $Accessory array (now guaranteed to be an array)
            foreach ($accessory as $activity) {
                if (isset($accessoryCounts[$activity])) {
                    $accessoryCounts[$activity]++;
                } else {
                    $accessoryCounts[$activity] = 1;
                }
            }
        });

        return $accessoryCounts;
    }

    protected function getAccessoryFireExtinguisherCounts()
    {
        $accessoryCounts = [];

        // Iterate over each item in accessory field
        $this->collection->each(function ($item) use (&$accessoryCounts) {
            $accessory = []; // Initialize with empty array

            if ($item['equipment_category'] === 'fire extinguisher') {
                if (isset($item['pivot']['accessory']) && !empty($item['pivot']['accessory'])) {
                    $decodedAccessory = json_decode($item['pivot']['accessory'], true);
                    if (is_array($decodedAccessory)) {
                        $accessory = $decodedAccessory; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'Accessory' field for item: " . $item['id']);
                    }
                }

                // Process the $accessory array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];
                $pressure = $item['equipment_pressure'];
                $weightValue = $item['equipment_weight_value'];
                $weightUnit = $item['equipment_weight_unit'];

                foreach ($accessory as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' ' . $pressure . ' ' . $weightValue . ' ' . $weightUnit . ' : ' . $activity;
                    $accessoryCounts[$key] = isset($accessoryCounts[$key]) ? $accessoryCounts[$key] + 1 : 1;
                }
            }
        });

        return $accessoryCounts;
    }

    protected function getAccessoryFireHoseCounts()
    {
        $accessoryCounts = [];

        // Iterate over each item in accessory field
        $this->collection->each(function ($item) use (&$accessoryCounts) {
            $accessory = []; // Initialize with empty array

            if ($item['equipment_category'] === 'fire hose') {
                if (isset($item['pivot']['accessory']) && !empty($item['pivot']['accessory'])) {
                    $decodedAccessory = json_decode($item['pivot']['accessory'], true);
                    if (is_array($decodedAccessory)) {
                        $accessory = $decodedAccessory; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'Accessory' field for item: " . $item['id']);
                    }
                }

                // Process the $accessory array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];

                foreach ($accessory as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' : ' . $activity;
                    $accessoryCounts[$key] = isset($accessoryCounts[$key]) ? $accessoryCounts[$key] + 1 : 1;
                }
            }
        });

        return $accessoryCounts;
    }

    protected function getAccessoryOthersEquipmentCounts()
    {
        $accessoryCounts = [];

        // Iterate over each item in accessory field
        $this->collection->each(function ($item) use (&$accessoryCounts) {
            $accessory = []; // Initialize with empty array

            if ($item['equipment_category'] !== 'fire hose' && $item['equipment_category'] !== 'fire extinguisher') {
                if (isset($item['pivot']['accessory']) && !empty($item['pivot']['accessory'])) {
                    $decodedAccessory = json_decode($item['pivot']['accessory'], true);
                    if (is_array($decodedAccessory)) {
                        $accessory = $decodedAccessory; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'Accessory' field for item: " . $item['id']);
                    }
                }

                // Process the $accessory array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];
                $pressure = $item['equipment_pressure'];
                $weightValue = $item['equipment_weight_value'];
                $weightUnit = $item['equipment_weight_unit'];
                foreach ($accessory as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' ' . $pressure . ' ' . $weightValue . ' ' . $weightUnit . ' : ' . $activity;
                    $accessoryCounts[$key] = isset($accessoryCounts[$key]) ? $accessoryCounts[$key] + 1 : 1;
                }
            }
        });

        return $accessoryCounts;
    }

    protected function getSupplyCounts()
    {
        $supplyCounts = [];

        // Iterate over each item in supply field
        $this->collection->each(function ($item) use (&$supplyCounts) {
            $supply = []; // Initialize with empty array

            if (isset($item['pivot']['supply']) && !empty($item['pivot']['supply'])) {
                $decodedSupply = json_decode($item['pivot']['supply'], true);
                if (is_array($decodedSupply)) {
                    $supply = $decodedSupply; // Use decoded array only if valid
                } else {
                    // Handle invalid JSON (log error, set default value)
                    error_log("Invalid JSON data in 'supply' field for item: " . $item['id']);
                }
            }

            // Process the $supply array (now guaranteed to be an array)
            foreach ($supply as $activity) {
                if (isset($supplyCounts[$activity])) {
                    $supplyCounts[$activity]++;
                } else {
                    $supplyCounts[$activity] = 1;
                }
            }
        });

        return $supplyCounts;
    }

    protected function getSupplyFireExtinguisherCounts()
    {
        $supplyCounts = [];

        // Iterate over each item in supply field
        $this->collection->each(function ($item) use (&$supplyCounts) {
            $supply = []; // Initialize with empty array

            if ($item['equipment_category'] === 'fire extinguisher') {
                if (isset($item['pivot']['supply']) && !empty($item['pivot']['supply'])) {
                    $decodedSupply = json_decode($item['pivot']['supply'], true);
                    if (is_array($decodedSupply)) {
                        $supply = $decodedSupply; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'supply' field for item: " . $item['id']);
                    }
                }

                // Process the $supply array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];
                $pressure = $item['equipment_pressure'];
                $weightValue = $item['equipment_weight_value'];
                $weightUnit = $item['equipment_weight_unit'];

                foreach ($supply as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' ' . $pressure . ' ' . $weightValue . ' ' . $weightUnit . ' : ' . $activity;
                    $supplyCounts[$key] = isset($supplyCounts[$key]) ? $supplyCounts[$key] + 1 : 1;
                }
            }
        });

        return $supplyCounts;
    }

    protected function getSupplyFireHoseCounts()
    {
        $supplyCounts = [];

        // Iterate over each item in supply field
        $this->collection->each(function ($item) use (&$supplyCounts) {
            $supply = []; // Initialize with empty array

            if ($item['equipment_category'] === 'fire hose') {
                if (isset($item['pivot']['supply']) && !empty($item['pivot']['supply'])) {
                    $decodedSupply = json_decode($item['pivot']['supply'], true);
                    if (is_array($decodedSupply)) {
                        $supply = $decodedSupply; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'supply' field for item: " . $item['id']);
                    }
                }

                // Process the $supply array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];

                foreach ($supply as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' : ' . $activity;
                    $supplyCounts[$key] = isset($supplyCounts[$key]) ? $supplyCounts[$key] + 1 : 1;
                }
            }
        });

        return $supplyCounts;
    }

    protected function getSupplyOthersEquipmentCounts()
    {
        $supplyCounts = [];

        // Iterate over each item in supply field
        $this->collection->each(function ($item) use (&$supplyCounts) {
            $supply = []; // Initialize with empty array

            if ($item['equipment_category'] !== 'fire hose' && $item['equipment_category'] !== 'fire extinguisher') {
                if (isset($item['pivot']['supply']) && !empty($item['pivot']['supply'])) {
                    $decodedSupply = json_decode($item['pivot']['supply'], true);
                    if (is_array($decodedSupply)) {
                        $supply = $decodedSupply; // Use decoded array only if valid
                    } else {
                        // Handle invalid JSON (log error, set default value)
                        error_log("Invalid JSON data in 'supply' field for item: " . $item['id']);
                    }
                }

                // Process the $supply array (now guaranteed to be an array)
                $category = $item['equipment_category'];
                $model = $item['equipment_model'];
                $pressure = $item['equipment_pressure'];
                $weightValue = $item['equipment_weight_value'];
                $weightUnit = $item['equipment_weight_unit'];

                foreach ($supply as $activity) {
                    $key = $item['location'] . ' ' . $category . ' ' . $model . ' ' . $pressure . ' ' . $weightValue . ' ' . $weightUnit . ' : ' . $activity;
                    $supplyCounts[$key] = isset($supplyCounts[$key]) ? $supplyCounts[$key] + 1 : 1;
                }
            }
        });

        return $supplyCounts;
    }
}
