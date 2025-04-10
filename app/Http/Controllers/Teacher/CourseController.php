<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
  public function index()
  {
      $courses = Course::where('created_by', Auth::id())->latest()->get();
      return Inertia::render('Teacher/Index', [
          'courses' => $courses,
      ]);
  }

  public function create()
  {
    return Inertia::render('Teacher/Create');
  }

  public function store(Request $request)
  {
      $validated = $request->validate([
          'title' => 'required|string|max:255',
          'trailer_url' => 'nullable|url',
          'description' => 'nullable|string',
          'level' => 'required|string',
          'topic' => 'nullable|string',
          'is_free' => 'boolean',
          'thumbnail' => 'nullable|string',
          'language' => 'required|string',
          'status' => 'required|in:draft,published',
      ]);

      $validated['slug'] = Str::slug($request->title) . '-' . time();
      $validated['created_by'] = Auth::id();

      Course::create($validated);

      return redirect()->route('teacher.courses.index')->with('success', 'دوره با موفقیت ایجاد شد.');
  }

  public function edit(Course $course)
  {
      $this->authorize('update', $course);
      return view('teacher.courses.edit', compact('course'));
  }

  public function update(Request $request, Course $course)
  {
      $this->authorize('update', $course);

      $validated = $request->validate([
          'title' => 'required|string|max:255',
          'trailer_url' => 'nullable|url',
          'description' => 'nullable|string',
          'level' => 'required|string',
          'topic' => 'nullable|string',
          'is_free' => 'boolean',
          'thumbnail' => 'nullable|string',
          'language' => 'required|string',
          'status' => 'required|in:draft,published',
      ]);

      $course->update($validated);

      return redirect()->route('teacher.courses.update')->with('success', 'دوره بروزرسانی شد.');
  }

  public function destroy(Course $course)
  {
      $this->authorize('delete', $course);
      $course->delete();
      return redirect()->route('teacher.courses.delete')->with('success', 'دوره حذف شد.');
  }
}
