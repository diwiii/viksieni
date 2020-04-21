<?php

namespace App\Http\Controllers;

use App\Section;
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
        return Section::all();
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
        $section = $section->toArray();
        return view('section.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
        $section = $section->toArray();
        $sections = Section::all();
        return view('section.edit', compact('section', 'sections'));
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
        // Section please update model from validated and processed request data.
        $section->update($this->processRequestData($request));

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

        return redirect(route('root'));
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
     * Returns array with altered 'image' value;
     * 
     * @return array
     */
    protected function processImage($data) 
    {
        // Generate image name from slug and date
        // $imageName = $data['slug']."-".date("d-m-y-his");
        

        // Store image as $imageName
        // $imagePath = $data['image']->storeAs('uploads/section', $imageName);


        // Store uploaded image
        $imagePath = $data['image']->store('uploads/section', 'public');

        //Fetch the image
        $image = \Image::make(public_path("/storage/{$imagePath}"));

        // Get image name which will be saved in database
        $imageName = $image->basename;
        
        // Save image name
        $data = array_merge($data, ['image' => $imageName]);

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
