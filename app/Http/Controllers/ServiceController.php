<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::orderBy('name')->get();
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




public function store(Request $request) 
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'required|integer',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $service = new Service();
    $service->name = $request->name;
    $service->description = $request->description;
    $service->duration = $request->duration;
    $service->price = $request->price;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();  // Unique name

        

        // Resize to exactly 128x128px
        Image::make($image)
             ->fit(128, 128)
             ->save(public_path('images/' . $imageName));

        $service->image = $imageName;
    }

    $service->save();

    return redirect()->route('services.index')
                     ->with('success', 'Service created successfully');
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, Service $service)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'duration' => 'required|integer',
        'price' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $service->name = $request->name;
    $service->description = $request->description;
    $service->duration = $request->duration;
    $service->price = $request->price;

    // Only overwrite image if a new file is uploaded
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $service->image = $imageName;
    }

    $service->save();

    return redirect()->route('services.index')
                     ->with('success', 'Service updated successfully.');
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')
        ->with('success', 'Service deleted successfully');
    }

    // In app/Console/Commands/ResizeServiceImages.php


public function handle()
{
    $services = Service::whereNotNull('image')->get();
    foreach ($services as $service) {
        $imagePath = public_path('images/' . $service->image);
        if (file_exists($imagePath)) {
            Image::make($imagePath)
                 ->fit(128, 128)
                 ->save($imagePath);  // Overwrite with resized version
        }
    }
    $this->info('All service images resized to 128x128px.');
}
}
