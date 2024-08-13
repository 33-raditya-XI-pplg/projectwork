<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $slider = Slider::all();
        $page = Page::all();
        return view('admin.slider.index', compact('slider', 'page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'required|image|mimes:jpg,jpeg,png,bmp|max:2048',
            'position' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        // Upload image
        if ($request->hasFile('image_file')) {
            $imageName = time().'.'.$request->image_file->extension();
            $request->image_file->move(public_path('images/sliders'), $imageName);
            $image_url = 'images/sliders/' . $imageName;
        }

        Slider::create([
            'page_id' => $request->page_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $image_url, // Use the uploaded image URL
            'position' => $request->position,
            'status' => $request->status,
        ]);

        return redirect()->route('slider.index')
            ->with('success', 'Slider created successfully.');
    }

    public function update(Request $request, Slider $slider)
    {
        // Validate the request
        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_file_edit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image upload
            'position' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload
        if ($request->hasFile('image_file_edit')) {
            // Store the new image
            $imagePath = $request->file('image_file_edit')->store('public/images');
            $imageUrl = Storage::url($imagePath);

            // Update the slider with the new image URL
            $slider->image_url = $imageUrl;
        }

        // Update other fields
        $slider->update($request->only([
            'page_id',
            'title',
            'description',
            'position',
            'status',
        ]));

        return redirect()->route('slider.index')
            ->with('success', 'Slider updated successfully.');
    }


    public function destroy(Slider $slider)
    {
        $slider->delete();

        return redirect()->route('slider.index')
            ->with('success', 'Slider deleted successfully.');
    }
}
