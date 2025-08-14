<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CourseController extends Controller
{
    public function dashboard()
    {
        /** @var User $teacher */
        $teacher = auth()->user();

        if (!$teacher->teacher) {
            $teacher->teacher()->create([]);
            $teacher->refresh();
        }

        // آمار کلی
        $stats = [
            'courses' => $teacher->courses()->count(),
            'activeStudents' => $teacher->students()->count(),
        ];

        // آخرین دوره‌ها - نسخه اصلاح شده
        $latestCourses = $teacher->courses()
            ->select('courses.id', 'courses.title', 'courses.created_at') // اضافه کردن created_at
            ->withCount(['users as student_count'])
            ->with(['users' => function ($query) use ($teacher) {
                $query->select('course_user.progress')
                    ->where('user_id', $teacher->id);
            }])
            ->orderBy('courses.created_at', 'desc') // مشخص کردن جدول
            ->take(3)
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->title,
                    'students' => $course->student_count,
                    'progress' => $course->users->first()->pivot->progress ?? 0,
                    'created_at' => $course->created_at, // در صورت نیاز
                ];
            });

        // دانشجویان آنلاین
        $onlineStudents = $teacher->students()
            ->select('users.id', 'users.name', 'users.profile_photo_path')
            ->with(['courses' => function ($query) use ($teacher) {
                $query->whereIn('courses.id', $teacher->courses()->pluck('courses.id'))
                    ->limit(1);
            }])
            ->take(4)
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'avatar' => $student->profile_photo_url,
                    'course' => $student->courses->first()->title ?? 'بدون دوره',
                ];
            });

        return Inertia::render('Teacher/Dashboard', [
            'stats' => $stats,
            'latestCourses' => $latestCourses,
            'onlineStudents' => $onlineStudents,
            'teacherProfile' => $teacher->teacher,
        ]);
    }

    // protected function getActivityData(User $teacher)
    // {
    //     // داده‌های واقعی فعالیت دانشجویان در 6 ماه اخیر
    //     $activity = $teacher->students()
    //         ->selectRaw('strftime("%m", last_activity_at) as month, count(*) as count')
    //         ->where('last_activity_at', '>=', Carbon::now()->subMonths(6))
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->pluck('count')
    //         ->toArray();
    //
    //     return [
    //         'labels' => $this->getPersianMonthNames(6),
    //         'datasets' => [
    //             [
    //                 'label' => 'فعالیت دانشجویان',
    //                 'data' => $activity,
    //                 'backgroundColor' => 'rgba(99, 102, 241, 0.2)',
    //                 'borderColor' => 'rgba(99, 102, 241, 1)',
    //                 'borderWidth' => 2,
    //                 'tension' => 0.3,
    //                 'fill' => true
    //             ]
    //         ]
    //     ];
    // }

    // protected function getPerformanceData(User $teacher)
    // {
    //     $courses = $teacher->courses()
    //         ->with(['quizzes' => function($query) {
    //             $query->select('course_id')
    //                 ->selectRaw('AVG(user_quiz_attempts.score) as avg_score')
    //                 ->join('user_quiz_attempts', 'quizzes.id', '=', 'user_quiz_attempts.quiz_id')
    //                 ->groupBy('course_id');
    //         }])
    //         ->select('courses.id', 'courses.title')
    //         ->get();
    //
    //     return [
    //         'labels' => $courses->pluck('title')->toArray(),
    //         'datasets' => [
    //             [
    //                 'label' => 'میانگین نمرات',
    //                 'data' => $courses->map(function($course) {
    //                     return $course->quizzes->isNotEmpty()
    //                         ? round($course->quizzes->first()->avg_score, 2)
    //                         : 0;
    //                 }),
    //                 'backgroundColor' => [
    //                     'rgba(99, 102, 241, 0.7)',
    //                     'rgba(59, 130, 246, 0.7)',
    //                     'rgba(168, 85, 247, 0.7)',
    //                     'rgba(16, 185, 129, 0.7)',
    //                     'rgba(245, 158, 11, 0.7)'
    //                 ],
    //                 'borderWidth' => 1
    //             ]
    //         ]
    //     ];
    // }

    protected function getPersianMonthNames($count)
    {
        $months = [
            'فروردین', 'اردیبهشت', 'خرداد',
            'تیر', 'مرداد', 'شهریور',
            'مهر', 'آبان', 'آذر',
            'دی', 'بهمن', 'اسفند',
        ];

        $currentMonth = (int) date('m') - 1;
        $result = [];

        for ($i = 0; $i < $count; $i++) {
            $index = ($currentMonth - $i + 12) % 12;
            $result[] = $months[$index];
        }

        return array_reverse($result);
    }

    public function getActivityDataByRange(Request $request)
    {
        $range = $request->input('range', '3m');
        $teacher = auth()->user();

        $query = $teacher->students()
            ->selectRaw('strftime("%m", last_activity_at) as month, count(*) as count');

        switch ($range) {
            case '6m':
                $query->where('last_activity_at', '>=', Carbon::now()->subMonths(6));
                $labels = $this->getPersianMonthNames(6);
                break;
            case '1y':
                $query->where('last_activity_at', '>=', Carbon::now()->subYear());
                $labels = $this->getPersianMonthNames(12);
                break;
            default: // 3m
                $query->where('last_activity_at', '>=', Carbon::now()->subMonths(3));
                $labels = $this->getPersianMonthNames(3);
        }

        $data = $query->groupBy('month')
            ->orderBy('month')
            ->pluck('count')
            ->toArray();

        return response()->json([
            'data' => $data,
            'labels' => $labels,
        ]);
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
            'status' => 'required|in:draft,published',
        ]);

        $slug = Str::slug($request->title);
        $count = Course::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug.'-'.time();
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
