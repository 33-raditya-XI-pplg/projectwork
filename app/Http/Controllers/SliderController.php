<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Slider;
use Illuminate\Http\Request;

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
            'image_url' => 'required|string|max:255',
            'position' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        Slider::create([
            'page_id' => $request->page_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'position' => $request->position,
            'status' => $request->status,
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
            'image_url' => 'required|string|max:255',
            'position' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        $slider->update($request->only([
            'page_id',
            'title',
            'description',
            'image_url',
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
