<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class OmnivaController extends Controller
{
    public function index()
    {
        // This is LOCAL JSON from omniva
        $jsonURL = asset('storage/uploads/omniva/lvCities.json');

        // Fetch data from JSON
        $data = file_get_contents($jsonURL);

        // Convert JSON to PHP variable
        $cities = json_decode($data, 1);

        // Create collection of Parcel Machines, pass in converted json
        $parcelMachines = $this->parcelMachines($cities);

        // If url query contains ?zip key use it to indetify single parcelMachine
        // and store into session.
        if(request('zip')) {
            $zip = request('zip');

            $parcelMachine = $parcelMachines->firstWhere('ZIP', $zip);
            
            // Store in session chosen $parcelMachine
            session()->put('parcelMachine', (array)$parcelMachine);
            
            // Redirect to cart
            return redirect()->route('grozs.index');
        }

        // If url query contains ?meklet key do 
        if(request('meklet')){

            // Validate the address search query
            $validatedQuery = request()->validate([
                'meklet' => 'min:2|regex:/^[\pL\s\d\-\,\/]+$/u'
            ]);
            
            // Address to use as reference point
            $address = $validatedQuery['meklet'];

            // Get x and y coordinates from GOOGLE geocoding
            $pointOfReference = $this->pointOfReference($address);

            // If we have X and Y coordinates, look for nearby parcelmachines
            if (isset($pointOfReference)) {
                
                // Returns collection of parcel machines with DISTANCE property, relative to point of reference.
                $parcelMachines = $this->nearbyParcelMachines($pointOfReference, $parcelMachines);

                // Sort by distance and cast to array
                $parcelMachines = $parcelMachines->sortBy('DISTANCE')->map(function ($parcelMachine){
                    return (array)$parcelMachine;
                })->toArray();

                return view('omniva.index', compact('parcelMachines'));
            }
        }

        // If we get key ?pilseta=value from url query, return list of parcelMachines
        // for currently selected city.
        if(request('pilseta') && isset($cities[request('pilseta')])){

            // Use the value as key to pick city and make array with parcelMachines 
            $parcelMachines = $cities[request('pilseta')];

            return view('omniva.index', compact('parcelMachines'));
        }

        return view('omniva.index', compact('cities'));
    }

    /**
     * Create lvCities.json from omniva/locations.json
     */
    public function omnivaJSON()
    {
        // This is LOCAL JSON from omniva
        // $jsonURL = asset('storage/uploads/omniva/locations.json');

        // This is JSON URL from request
        $jsonURL = request()->url;

        // Fetch data from JSON
        $data = file_get_contents($jsonURL);

        // Convert JSON to PHP variable
        $json = json_decode($data, 1);

        // This array will contain Latvian parcel machine locations.
        $latvia = array();

        // This array will contain unique city names
        $uniqueCities = array();

        // Loop through all JSON items and filter out parcel machines with LV code
        foreach($json as $item) {
            // If item contains LV code
            if($item['A0_NAME'] === 'LV' ) {

                // Add item to array
                $latvia[] = $item;

                // Add item if it is not in array uniqueCities
                if(!in_array($item['A1_NAME'], $uniqueCities)){
                    // Add item to array
                    $uniqueCities[] = $item['A1_NAME'];
                }
            }
        }

        /**
         * Create city key names from original name
         * Example: Limbaži -> limbazi
         */

        // This array will contain city name Keys and associated parcel machines
        // This is multi dimensional array 
        // Example: limbazi[0]->parcelMachineItem
        $cityKeys = array();

        // Loop through unique city array
        foreach($uniqueCities as $city) {

            // Transliterate original city name to ascii, set it to lower case and into string.
            $key = Str::of($city)->ascii()->lower()->__toString();

            // Loop through latvia array
            foreach($latvia as $item){
                // If Parcel Machine city name is equal to city from unique array
                if($item['A1_NAME'] === $city){
                    // Add Parcel machine to array
                    $cityKeys[$key][] = $item;
                }
            }
        }

        // Encode array to json
        $json = json_encode($cityKeys);
        // Save file 
        Storage::put('public/uploads/omniva/lvCities.json', $json);

        return 'File created: '.asset('storage/uploads/omniva/lvCities.json');
    }

    /**
     * Returns x and y coordinates of requested address.
     * Which will be used as point of reference to get the nearby parcel machines.
     */
    public function pointOfReference($address) {

            // dd(Storage::delete('public/uploads/omniva/geocoding.json'));
                    
            // File where to store response from google - localGeocode storage
            $filePath = 'public/uploads/omniva/geocoding.json';
            
            // Create localGeocode json file if not found
            if(Storage::missing($filePath)){
                Storage::put($filePath, '');
            }

            // Fetch localy stored geocode responses from google
            $data = Storage::get($filePath);

            // Convert JSON to PHP array
            $localGeocodes = json_decode($data, 1);

            if (is_array($localGeocodes) && array_key_exists($address, $localGeocodes)) { 

                $response = $localGeocodes[$address];

            } else {

                $response = \GoogleMaps::load('geocoding')
                ->setParam (['address' => $address ])
                ->get();
            
                // Convert JSON to PHP array
                $response = json_decode($response, 1);

                // Store responses in associative array,
                // where key is search query and value is google response
                $localGeocodes[$address] = $response;

                // Encode php array to json
                $json = json_encode($localGeocodes);

                // Store json
                Storage::put($filePath, $json);
            }

            // Use search query as key to get response from local storage.
            $response = $localGeocodes[$address];

            // Point of reference for distance calculation
            $pointOfReference = array(
                'x' => $response['results'][0]['geometry']['location']['lng'],
                'y' => $response['results'][0]['geometry']['location']['lat']
            );

            return $pointOfReference;
    }

    /**
     * From converted JSON
     * Returns collection of parcel machines
     */
    public function parcelMachines($data) {
        // Create collection of parcel machines.
        $parcelMachines = collect();
        
        // Loop through arrays and push parcel machines to collection
        foreach($data as $city) {
            foreach ($city as $parcelMachine){
                // Cast to object and push to collection
                $parcelMachines->push((object)$parcelMachine);
            }
        }

        return $parcelMachines;
    }

    /**
     * Returns collection of parcel machines with DISTANCE property,
     * relative to point of reference.
     */
    public function nearbyParcelMachines($pointOfReference, $parcelMachines) {

        // Map into collection and calculate distance for every parcel machine based on point of reference
        $parcelMachines = $parcelMachines->map(function ($parcelMachine) use ($pointOfReference) {

            $location = array(
                'x' => $parcelMachine->X_COORDINATE,
                'y' => $parcelMachine->Y_COORDINATE
            );

            $distance = $this->distance($pointOfReference, $location);

            $parcelMachine->DISTANCE = $distance;

            return $parcelMachine;
            
        });
        
        return $parcelMachines;
    }

    /**
     * Use to calculate distance from reference point to target location, by
     * using Pythagoras Theorem
     * 
     * Returns longest side of triangle = hypotenuse
     */
    public function distance($fromLocation, $toLocation) {
        /**
         * If value is negative we use abs function to get absolute value
         * Cast float
         * Subtract x and y to get length for $a and $b sides of triangle
         */
        $a = abs( (float)$fromLocation['x'] - (float)$toLocation['x'] );
        $b = abs( (float)$fromLocation['y'] - (float)$toLocation['y'] );

        /**
         * The longest side of the triangle is called the "hypotenuse"
         * Use Pythagoras Theorem to calculate hypotenuse
         * a squared + b squared = c squared
         * Use sqrt function to calculate square root of squared hypotenuse
         */
        $hypotenuse = sqrt(pow($a, 2) + pow($b, 2));

        return $hypotenuse;
    }

}
