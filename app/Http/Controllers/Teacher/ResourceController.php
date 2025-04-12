<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $resources = Resource::with('course')
            ->when($request->course_id, fn($q) => $q->where('course_id', $request->course_id))
            ->latest()
            ->paginate(12);

        $courses = Course::pluck('title', 'id');

        return inertia('Teacher/Resources/Index', [
            'resources' => $resources,
            'courses' => $courses,
            'filters' => $request->only(['course_id'])
        ]);
    }

    public function create()
    {
        return inertia('Teacher/Resources/Create', [
            'courses' => Course::pluck('title', 'id')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'nullable|exists:courses,id',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,mp4,mov,avi|max:20480' // 20MB
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_path'] = $file->store('resources', 'public');
            $validated['type'] = $file->getClientOriginalExtension();
        }

        Resource::create($validated);

        return redirect()->route('teacher.resources.index')
            ->with('success', 'منبع جدید با موفقیت ایجاد شد');
    }

    public function edit(Resource $resource)
    {
        return inertia('Teacher/Resources/Edit', [
            'resource' => $resource,
            'courses' => Course::pluck('title', 'id')
        ]);
    }

    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'nullable|exists:courses,id',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,mp4,mov,avi|max:20480'
        ]);

        if ($request->hasFile('file')) {
            // حذف فایل قبلی
            if ($resource->file_path) {
                Storage::disk('public')->delete($resource->file_path);
            }

            $file = $request->file('file');
            $validated['file_path'] = $file->store('resources', 'public');
            $validated['type'] = $file->getClientOriginalExtension();
        }

        $resource->update($validated);

        return redirect()->route('teacher.resources.index')
            ->with('success', 'منبع با موفقیت به‌روزرسانی شد');
    }

    public function destroy(Resource $resource)
    {
        if ($resource->file_path) {
            Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();

        return back()->with('success', 'منبع با موفقیت حذف شد');
    }
}
