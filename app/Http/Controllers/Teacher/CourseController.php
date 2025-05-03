<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
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

    public function profile()
    {
        $teacher = Teacher::with('user')
        ->where('user_id', Auth::id())
            ->firstOrFail();
        return Inertia::render('Teacher/Profile', [
            'teacher' => $teacher,
        ]);
    }

    public function profile_update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'title' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'languages' => 'nullable|json',
            'experiences' => 'nullable|json',
            'social_links' => 'nullable|json',
            'teaching_methods' => 'nullable|json',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'remove_profile_photo' => 'nullable|boolean',
        ]);

        // آپدیت اطلاعات کاربر
        $teacher->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // آپدیت اطلاعات مدرس
        $teacherData = [
            'title' => $validated['title'],
            'bio' => $validated['bio'],
            'languages' => json_decode($validated['languages'], true),
            'experiences' => json_decode($validated['experiences'], true),
            'social_links' => json_decode($validated['social_links'], true),
            'teaching_methods' => json_decode($validated['teaching_methods'], true),
            'phone' => $validated['phone'],
            'location' => $validated['location'],
        ];

        if ($validated['remove_profile_photo'] ?? false) {
            if ($teacher->profile_photo_path) {
                Storage::delete($teacher->profile_photo_path);
                $teacher->profile_photo_path = null;
            }
        }

        // آپلود عکس جدید
        if ($request->hasFile('profile_photo')) {
            // حذف عکس قبلی اگر وجود دارد
            if ($teacher->profile_photo_path) {
                Storage::delete($teacher->profile_photo_path);
            }

            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $teacher->profile_photo_path = $path;
        }

        $teacher->save();

        $teacher->update($teacherData);

        return redirect()->back()->with('success', 'پروفایل با موفقیت به‌روزرسانی شد.');
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
            'price' => 'nullable|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trailer_url' => 'nullable|url',
            'language' => 'required|string|max:2',
            'status' => 'required|in:draft,published'
        ]);

        $slug = Str::slug($request->title);
            $count = Course::where('slug', $slug)->count();

            if ($count > 0) {
                $slug = $slug . '-' . time();
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
          'price' => 'nullable|numeric|min:0',
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
