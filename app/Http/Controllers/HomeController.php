<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function omnivaJSON()
    {
        // dd(request()->url);
        // This is LOCAL JSON from omniva
        // $jsonURL = asset('storage/uploads/omniva/locations.json');

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
}
