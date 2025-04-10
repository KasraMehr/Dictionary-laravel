<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{

  public function dashboard()
  {
    return Inertia::render('Teacher/Dashboard');
  }

  public function index()
    {
        $courses = Course::withCount(['users', 'course_lessons', 'quizzes'])
            ->get();

        return inertia('Teacher/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function create()
    {
        $levels = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
        $languages = ['en' => 'English', 'fa' => 'فارسی', 'ar' => 'العربية'];
        return inertia('Teacher/Courses/Create', [
            'levels' => $levels,
            'languages' => $languages,
        ]);
    }

    public function store(Request $request)
    {
        // اعتبارسنجی داده‌ها
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|string|in:A1,A2,B1,B2,C1,C2',
            'topic' => 'nullable|string|max:255',
            'is_free' => 'boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_url' => 'nullable|url',
            'language' => 'required|string|max:2',
            'status' => 'required|in:draft,published'
        ]);

        $slug = Str::slug($request->title);
            $count = Course::where('slug', $slug)->count();

            if ($count > 0) {
                $slug = $slug . '-' . time(); // اضافه کردن timestamp برای منحصر به فرد بودن
            }


        // ذخیره تصویر thumbnail اگر وجود دارد
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('course-thumbnails', 'public');
        }

        $validated['slug'] = $slug;

        // اضافه کردن کاربر ایجاد کننده
        $validated['created_by'] = auth()->id();

        // ایجاد دوره جدید
        $course = Course::create($validated);

        return redirect()->route('teacher.courses.index', $course)
            ->with('success', 'دوره با موفقیت ایجاد شد.');
    }

    public function show(Course $course)
    {
        $course->load(['users', 'course_lessons', 'quizzes']);

        return inertia('Teacher/Courses/Show', [
            'course' => $course,
        ]);
    }

    public function edit(Course $course)
    {
          $levels = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];

          return inertia('Teacher/Courses/Edit', [
              'course' => $course,
              'levels' => $levels,
          ]);
    }
    public function update(Request $request, Course $course)
    {
      $validated = $request->validate([
          'title' => 'required|string|max:255',
          'description' => 'nullable|string',
          'level' => 'required|in:A1,A2,B1,B2,C1,C2',
          'topic' => 'nullable|string|max:255',
          'is_free' => 'boolean',
          'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
          'trailer_url' => 'nullable|url',
          'language' => 'required|string|max:2',
          'status' => 'required|in:draft,published',
      ]);

      // مدیریت تصویر
      if ($request->hasFile('thumbnail')) {
          // حذف تصویر قبلی اگر وجود داشت
          if ($course->thumbnail) {
              Storage::disk('public')->delete($course->thumbnail);
          }
          $validated['thumbnail'] = $request->file('thumbnail')->store('course-thumbnails', 'public');
      } elseif ($request->remove_thumbnail) {
          if ($course->thumbnail) {
              Storage::disk('public')->delete($course->thumbnail);
          }
          $validated['thumbnail'] = null;
      }

      $course->update($validated);

      return redirect()->route('teacher.courses.index')
          ->with('success', 'دوره با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('teacher.courses.index')
            ->with('success', 'دوره با موفقیت حذف شد.');
    }
}
