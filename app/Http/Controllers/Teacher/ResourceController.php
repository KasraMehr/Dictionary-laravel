<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\Course;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index(Course $course)
     {
         $resources = $course->resources()->paginate(10);
         return view('teacher.resources.index', compact('course', 'resources'));
     }

     public function create(Course $course)
     {
         return view('teacher.resources.create', compact('course'));
     }

     public function store(Request $request, Course $course)
     {
         $validated = $request->validate([
             'title' => 'required|string|max:255',
             'file_url' => 'nullable|string',
             'type' => 'required|string',
             'description' => 'nullable|string',
         ]);

         $course->resources()->create($validated);

         return redirect()->route('teacher.courses.resources.index', $course)->with('success', 'منبع اضافه شد.');
     }

     public function edit(Course $course, Resource $resource)
     {
         return view('teacher.resources.edit', compact('course', 'resource'));
     }

     public function update(Request $request, Course $course, Resource $resource)
     {
         $validated = $request->validate([
             'title' => 'required|string|max:255',
             'file_url' => 'nullable|string',
             'type' => 'required|string',
             'description' => 'nullable|string',
         ]);

         $resource->update($validated);

         return redirect()->route('teacher.courses.resources.index', $course)->with('success', 'منبع بروزرسانی شد.');
     }

     public function destroy(Course $course, Resource $resource)
     {
         $resource->delete();
         return back()->with('success', 'منبع حذف شد.');
     }
}
