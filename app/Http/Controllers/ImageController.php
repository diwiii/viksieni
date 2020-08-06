<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Http\Requests\ImageRequest;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $images = Image::all();
        return view('image.index', compact('images'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('image.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        // Image model please create model from validated data.
        $image = Image::create($this->processRequestData($request));

        // Add sizes record for this Image
        $image->sizes()->createMany([

            [
            'width'=>768,
            'url'=>'768/'.$image->url
            ],

            [
            'width'=>480,
            'url'=>'480/'.$image->url
            ]

        ]);

        return back()->with('status', 'Image uploaded!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //

        return view('image.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
        return view('image.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageRequest $request, Image $image)
    {
        $image->update($this->processRequestData($request));
        return redirect(route('image.index'))->with('status', 'Image updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
        $image->delete();

        return back()->with('status', 'Image with id: '.$image->id.' removed!');
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
        if (array_key_exists('image', $request) && $request['image'] != null) {
            $request = $this->processImage($request);
        }
        return $request;
    }

    /**
     * Returns array with altered 'image' value, 
     * Returns array with additional key -> image_id
     * 
     * 
     * @return array
     */
    protected function processImage($data) 
    {
        // Generate image name from slug and date
        // $imageName = $data['slug']."-".date("d-m-y-his");
        

        // Store image as $imageName
        // $imagePath = $data['image']->storeAs('uploads/section', $imageName);


        // Store uploaded image , atm will store in images folder
        $imagePath = $data['image']->store('uploads/images', 'public');

        // Keep in mind that "Image" and "\Image" are two different things

        //Fetch the image
        $image = \Image::make(public_path("/storage/{$imagePath}"));

        // Get image name which will be saved in database and used as url name
        $imageName = $image->basename;
        
        // Save image url name back to array
        $data = array_merge($data, [
            'url' => $imageName
        ]);

        // Remove image key from request.
        unset($data['image']);

        //EDIT THE IMAGE SIZES

        //TODO if we dont have folders 768 and 480 please create them, else we get errors.

        // Limit maximum image width to 1024px, also prevent from upsizing
        $image->widen(1024, function ($constraint) {
            $constraint->upsize();
        });
        $image->save();

        //Fetch the image
        $image = \Image::make(public_path("/storage/{$imagePath}"));
        //Limit maximum image width to 768px, also prevent from upsizing
        $image->widen(768, function ($constraint) {
            $constraint->upsize();
        });
        $image->save($image->dirname."/768/".$image->basename);
        
        //Fetch the image
        $image = \Image::make(public_path("/storage/{$imagePath}"));
        //Limit maximum image width to 480px, also prevent from upsizing
        $image->widen(480, function ($constraint) {
            $constraint->upsize();
        });
        $image->save($image->dirname."/480/".$image->basename);

        

        return $data;
    }
}
