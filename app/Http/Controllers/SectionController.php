<?php

namespace App\Http\Controllers;

use App\Section;
use App\Image;
use App\Http\Requests\SectionRequest;

use Illuminate\Http\Request; // Šo vajag?


class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sections =  Section::orderBy('arrangement', 'desc')->get();
        return view('section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('section.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        // Section model please create model vai object? from validated data.
        Section::create($this->processRequestData($request));

        return redirect(route('root'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
        // $section = $section->toArray();
        return view('section.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     * 
     */
    public function edit(Section $section)
    {
        // Set $image to null in case if we don't get imageId
        $image = null;

        // If url query contains ?select=image
        if (request('select') === 'image') {
            $images = Image::all();
            
            // Return list of all images with option to select one for the section.
            // We pass Section to View so that we know for which section we choose image.
            return view('image.index', compact('images', 'section'));
        }

        // If url query contains ?imageId=$image->id
        if (request('imageId')) {
            $imageId = request('imageId');
            // Get the image for selected id or fail.
            $image = Image::findOrFail($imageId);
        }

        $sections = Section::all();

        return view('section.edit', compact('section', 'sections', 'image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        $request = $this->processRequestData($request);
        
        // Section please update model from validated and processed request data.
        $section->update($request);

        // If we have imageId attach it to section.
        if ( isset($request['imageId']) ) {
            $section->images()->attach($request['imageId']);
        }

        //Returns to edited resource
        return redirect($section->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
        $section->delete();

        return back()->with('status', 'Section with id: '.$section->id.' removed!');
    }

    /**
     * Process validated request data
     * 
     * @return array
     */

    protected function processRequestData($request) 
    {
        $request = $request->validated();
        
        // Check if image key exists
        // if (array_key_exists('image', $request) && $request['image'] != null) {
        //     $request = $this->processImage($request);
        // }
        return $request;
    }

    // /**
    //  * Returns array with altered 'image' value, 
    //  * Returns array with additional key -> image_id
    //  * 
    //  * 
    //  * @return array
    //  */
    // protected function processImage($data) 
    // {
    //     // Generate image name from slug and date
    //     // $imageName = $data['slug']."-".date("d-m-y-his");
        

    //     // Store image as $imageName
    //     // $imagePath = $data['image']->storeAs('uploads/section', $imageName);


    //     // Store uploaded image , atm will store in images folder
    //     $imagePath = $data['image']->store('uploads/images', 'public');

    //     // Keep in mind that "Image" and "\Image" are two different things

    //     //Fetch the image
    //     $image = \Image::make(public_path("/storage/{$imagePath}"));

    //     // Get image name which will be saved in database
    //     $imageName = $image->basename;
        
    //     // Create new record
    //     $imageRow = new Image;
    //     $imageRow = $imageRow->create(['url'=>$imageName]);
    //     // Create 2 sizes record;
    //     $imageRow->sizes()->createMany([

    //         [
    //         'width'=>768,
    //         'url'=>'768/'.$imageName
    //         ],

    //         [
    //         'width'=>480,
    //         'url'=>'480/'.$imageName
    //         ]

    //     ]);

    //     // Save image name and image_id back to array
    //     $data = array_merge($data, [
    //         'image' => $imageName,
    //         'image_id' => $imageRow->id
    //     ]);

    //     //EDIT THE IMAGE SIZES

    //     //TODO if we dont have folders 768 and 480 please create them, else we get errors.

    //     // Limit maximum image width to 1024px, also prevent from upsizing
    //     $image->widen(1024, function ($constraint) {
    //         $constraint->upsize();
    //     });
    //     $image->save();

    //     //Fetch the image
    //     $image = \Image::make(public_path("/storage/{$imagePath}"));
    //     //Limit maximum image width to 768px, also prevent from upsizing
    //     $image->widen(768, function ($constraint) {
    //         $constraint->upsize();
    //     });
    //     $image->save($image->dirname."/768/".$image->basename);
        
    //     //Fetch the image
    //     $image = \Image::make(public_path("/storage/{$imagePath}"));
    //     //Limit maximum image width to 480px, also prevent from upsizing
    //     $image->widen(480, function ($constraint) {
    //         $constraint->upsize();
    //     });
    //     $image->save($image->dirname."/480/".$image->basename);

        

    //     return $data;
    // }
}
