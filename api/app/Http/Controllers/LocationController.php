<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as objectValidator;
use App\Services\LocationsImportService;

/**
 * @todo 
 * Here is some recommendations if we attend to share our API with a client
 * You will find some example in this controller constructor
 *
 * 1. Implement JWT Authentication
 *
 * 2. Configure Middleware:
 *    - Create middleware to check for JWT tokens on protected routes
 *    - Apply middleware to specific routes or route groups
 * 
 * 3. Configure roles:
 *    - User roles help limit how a client can execute requests on the API, 
 *      including which methods they can run and which resources they can access.
 *
 * 4. Implement Rate Limiting:
 *    - Use a rate limiter to restrict API request frequency
 *    - Customize rate limiting per user or per endpoint as needed
 *
 * 5. Ensure Proper Documentation:
 *    - Document new API authentication flow and usage guidelines
 *    - Provide examples of how to authenticate and make authenticated requests
 *
 * 6. Testing
 */

class LocationController extends Controller
{
    /**
     * Locations import service instance
     * @var LocationsImportService $locationsImportService
     */
    private LocationsImportService $locationsImportService;

    /**
     * Create a new LocationController instance.
     * @return void
     */
    public function __construct(LocationsImportService $locationsImportService)
    {
        $this->locationsImportService = $locationsImportService;

        // Ensure the user is authenticated with a JWT token
        //$this->middleware('auth:api');

        // Apply rate limiting to prevent excessive requests
        //$this->middleware('throttle:60,1');

        // Custom middleware to check if the user has the admin role
        //$this->middleware('check.role:admin');
    }

    /**
     * Display a listing of the locations.
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {      
        // Lets get the list of all location
        $locations = Location::all();

        return response()->json($locations, 200);
    }

    /**
     * Display the specified location.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function get(int $id): JsonResponse
    {
        // Find a sing location by its id
        $location = Location::find($id);

        // Throw a Json response with a 404 http code for a non found location
        if (!$location) {
            return $this->locationNotFoundResponse();
        }

        return response()->json($location, 200);
    }

    /**
     * Update a specified location.
     *
     * @param  Request  $request
     * 
     * 
     * @return JsonResponse
     */
    public function update(Request $request,int $id): JsonResponse
    {   
        // Find a sing location by its id
        $location = Location::find($id);

        if (!$location) {
            return $this->locationNotFoundResponse();
        }

        // Validate the request
        $validatedData = $request->validate(Location::rules());

        // Update the location
        $location->update($validatedData);

        return response()->json($location, 200);
    }

    /**
     * Import the CSV file content into the database
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     * 
     * @todo The best way to upload a file is to create a dedicated job which will run in the background.
     *       In this way, we can avoid a timeout problem and ensure the file upload process does not block
     *       the main application thread. This will also allow for better scalability and error handling.
     */
    public function import(Request $request): JsonResponse
    {
        // Retrieve the uploaded file from the request
        $locationsFile = $request->file('locations');
        
        // Use the service to handle the import process
        $result = $this->locationsImportService->importLocations($locationsFile);

        // Handle errors during the import process
        if (isset($result['error'])) {
            return response()->json(['message' => $result['error']], $result['code']);
        }

        // Return response with the result of the import process
        return response()->json([
            'message' => $result['message'],
            'imported' => $result['imported'],
            'failed' => $result['failed']
        ], $result['code']);
    } 

    /**
     * Return a location not found response
     * @todo This is a quick way to not repeat this kind of exceptions
     * But I will suggest to do a specific exception location exception class for further usages
     *
     * @return JsonResponse
     */
    private function locationNotFoundResponse(): JsonResponse
    {
        return response()->json(['message' => 'Location not found'], 404);
    }
}
