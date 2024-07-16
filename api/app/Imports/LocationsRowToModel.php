<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class LocationsRowToModel implements ToModel,WithHeadingRow
{  
    
    /**
     * LocationsRowToModel constructor
     */
    public function __construct()
    {
        // Use the custom heading row formatter
        HeadingRowFormatter::extend('custom', function ($value) {
            return $value;
        });

        // Set the default heading row formatter to 'custom'
        HeadingRowFormatter::default('custom');
    }

    /**
     * Handle the Locations collection
     * 
     * @param Collection $locationsRows
     */
    public function collection(Collection $locationsRows)
    {
        return $locationsRows->map(function ($row) {
            return $this->model($locationRow);
        });
    }

    /**
     * Model the file content to an location data array
     * 
     * @param array $locationRow
     * 
     * @return array
     */
    public function model(array $locationRow): array
    {
        return [
            'name' => $locationRow['name'],
            'address' => $locationRow['address'],
            'status' => $locationRow['status'],
            'description' => $locationRow['description'],
            'phoneNumber' => $locationRow['phoneNumber'],
            'countryCode' => $locationRow['countryCode'],
        ];
    }
}
