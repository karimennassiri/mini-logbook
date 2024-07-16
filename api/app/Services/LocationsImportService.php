<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LocationsRowToModel;
use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;

class LocationsImportService
{
    // Empty construct
    public function __construct(){}

    /**
     * Import locations from a CSV file.
     *
     * @param UploadedFile $locationsFile
     * @return array
     */
    public function importLocations(UploadedFile $locationsFile): array
    {   
        // Imported locations array
        $importedLocations = [];
        // Failed locations array
        $failedLocations = [];

        // Validate the uploaded file
        if (!$this->isValidFile($locationsFile)) {
            return ['error' => 'Invalid CSV file', 'code' => 400];
        }
        
        // Format and remove header from the CSV data
        $locations = Excel::toCollection(new LocationsRowToModel, $locationsFile)
                    ->first()
                    ->skip(1);

        // Iterate through each location and attempt to import it
        foreach ($locations as $locationData) {
            $result = $this->importLocation($locationData);
            if ($result['success']) {
                $importedLocations[] = $result['location'];
            } else {
                $failedLocations[] = $result['error'];
            }
        }

        return [
            'message' => 'Import process completed',
            'imported' => $importedLocations,
            'failed' => $failedLocations,
            'code' => 207
        ];
    }

    /**
     * Check if the uploaded file is valid.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return bool
     */
    private function isValidFile($file): bool
    {
        return $file && $file->isValid();
    }

    /**
     * Attempt to import a single location from CSV data.
     *
     * @param array $locationData
     * @return array
     */
    private function importLocation($locationData): array
    {
        // Validate the individual location data
        $validator = Validator::make($locationData->toArray(), Location::rules());

        if ($validator->fails()) {
            return [
                'success' => false,
                'error' => $this->setFailedLocations($locationData, $validator)
            ];
        }

        // Create and save the new location
        $location = Location::create($locationData->toArray());
        if (!$location) {
            return [
                'success' => false,
                'error' => $this->setFailedLocations($locationData, $validator)
            ];
        }

        return [
            'success' => true,
            'location' => $location
        ];
    }

    /**
     * Set error information for failed location imports.
     *
     * @param Object $locationData
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return array
     */
    private function setFailedLocations(Object $locationData, $validator): array
    {
        return [
            'locationData' => $locationData,
            'errors' => $validator->errors()
        ];
    }
}
