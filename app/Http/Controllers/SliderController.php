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
        $Title = 'Management';
        $subtitle = 'Slider';
        return view('admin.slider.index', compact('slider', 'page', 'Title', 'subtitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_file' => 'required|image|mimes:jpg,jpeg,png,bmp|max:2048',
            'position' => 'required|integer',
            'status' => 'nullable|boolean',
        ]);


        $cleanDescription = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->description);

        $image_url = null;
        if ($request->hasFile('image_file')) {
            $imageName = time() . '.' . $request->image_file->extension();
            $request->image_file->move(public_path('images/sliders'), $imageName);
            $image_url = 'images/sliders/' . $imageName;
        }

        Slider::create([
            'page_id' => $request->page_id,
            'title' => $request->title,
            'description' => $cleanDescription,
            'image_url' => $image_url,
            'position' => $request->position,
            'status' => $request->boolean('status', false),
        ]);

        return redirect()->route('slider.index')
            ->with('success', 'Slider created successfully.');
    }


    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_file_edit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'position' => 'required|integer',
            'status' => 'nullable|boolean',
            'status_hidden' => 'nullable|boolean',
        ]);


        $cleanDescription = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->description);


        if ($request->hasFile('image_file_edit')) {
            $imagePath = $request->file('image_file_edit')->store('public/images');
            $imageUrl = Storage::url($imagePath);

            $slider->image_url = $imageUrl;
        }


        $status = $request->input('status', 0) == '1' ? 1 : 0;


        $slider->update([
            'page_id' => $request->page_id,
            'title' => $request->title,
            'description' => $cleanDescription,
            'position' => $request->position,
            'status' => $status,
        ]);

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
