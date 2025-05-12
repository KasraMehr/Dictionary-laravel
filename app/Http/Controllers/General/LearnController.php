<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Teacher;
use App\Models\Word;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;


class LearnController extends Controller
{
    public function learn()
    {
      return Inertia::render('General/Learn/Learn');
    }

    public function levelLesson($level)
    {
        $words = Word::with(['categories:id,name'])
            ->where('level', $level)
            ->paginate(10);

        return Inertia::render('General/Learn/LearnLevel', [
            'level' => $level,
            'words' => $words->items(),
            'pagination' => [
                'current_page' => $words->currentPage(),
                'last_page' => $words->lastPage(),
                'per_page' => $words->perPage(),
                'total' => $words->total(),
            ]
        ]);
    }

    public function fetchWords(Request $request)
    {
        $request->validate([
            'level' => 'required|string|in:A1,A2,B1,B2,C1,C2',
            'page' => 'required|integer|min:1'
        ]);

        $words = Word::with(['categories:id,name'])
            ->where('level', $request->level)
            ->paginate(10, ['*'], 'page', $request->page);

        return response()->json([
            'words' => $words->items(),
            'pagination' => [
                'current_page' => $words->currentPage(),
                'last_page' => $words->lastPage(),
                'per_page' => $words->perPage(),
                'total' => $words->total(),
            ]
        ]);
    }

    public function topics()
    {
      $categories = Category::withCount('words')->get();

      return Inertia::render('General/Learn/Topics', [
          'categories' => $categories,
      ]);
    }

    public function levels()
    {
        return Inertia::render('General/Learn/Levels');
    }

    public function grammars()
    {
        return Inertia::render('General/Learn/Grammars');
    }

    public function teachers(Request $request)
    {
        $teachers = Teacher::with('user')
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('bio', 'like', "%{$search}%");
            })
            ->when($request->language, function ($query, $language) {
                $query->whereJsonContains('languages', $language);
            })
            ->when($request->teaching_methods, function ($query, $method) {
                $query->whereJsonContains('teaching_methods', $method);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('General/Learn/Teachers', [
            'teachers' => $teachers,
            'filters' => $request->only(['search', 'language', 'method'])
        ]);
    }

    public function courses(Request $request)
    {
        $query = Course::query();

        // فیلتر بر اساس جستجو
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        // فیلتر بر اساس سطح
        if ($request->has('level') && $request->level !== 'all') {
            $query->where('level', $request->level);
        }

        // فیلتر بر اساس موضوع
        if ($request->has('topic') && $request->topic !== 'all') {
            $query->where('topic', $request->topic);
        }

        // فقط دوره‌های منتشر شده
        $query->where('status', 'published');

        $courses = $query->get();

        // سطوح و موضوعات منحصر به فرد برای فیلترها
        $levels = Course::select('level')->distinct()->pluck('level');
        $topics = Course::select('topic')->distinct()->pluck('topic');

        return Inertia::render('General/Learn/Courses', [
            'courses' => $courses,
            'filters' => $request->only(['search', 'level', 'topic']),
            'levels' => $levels,
            'topics' => $topics,
        ]);
    }

    public function show_course($slug)
    {
        // یافتن دوره با اسلاگ داده شده
        $course = Course::with([
            'instructor',
//            'reviews.user',
//            'chapters.lessons'
        ])
//            ->withCount(['students', 'reviews'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

//        $course->average_rating = $course->reviews->avg('rating') ?? 0;

        // توزیع امتیازها
//        $ratingsDistribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
//        foreach ($course->reviews as $review) {
//            $ratingsDistribution[$review->rating]++;
//        }
//        $course->ratings_distribution = $ratingsDistribution;

        // یافتن دوره‌های مرتبط با الگوریتم پیشرفته
        $relatedCourses = $this->getRelatedCourses($course);

        return Inertia::render('General/Learn/CourseShow', [
            'course' => $course,
            'relatedCourses' => $relatedCourses,
        ]);
    }

    // الگوریتم یافتن دوره‌های مرتبط
    protected function getRelatedCourses(Course $currentCourse)
    {
        // 1. اولویت اول: دوره‌های هم‌موضوع از همان مدرس
        $sameInstructorSameTopic = Course::query()
            ->where('topic', $currentCourse->topic)
            ->where('created_by', $currentCourse->created_by)
            ->where('id', '!=', $currentCourse->id)
            ->where('status', 'published')
            ->withCount('students')
            ->orderBy('students_count', 'desc')
            ->limit(2)
            ->get();

        // اگر کافی نبود، ادامه می‌دهیم
        if ($sameInstructorSameTopic->count() < 3) {
            // 2. اولویت دوم: دوره‌های هم‌موضوع از مدرسین دیگر
            $sameTopic = Course::query()
                ->where('topic', $currentCourse->topic)
                ->where('id', '!=', $currentCourse->id)
                ->where('status', 'published')
                ->withCount('students')
                ->orderBy('students_count', 'desc')
                ->limit(3 - $sameInstructorSameTopic->count())
                ->get();

            $relatedCourses = $sameInstructorSameTopic->merge($sameTopic);
        } else {
            $relatedCourses = $sameInstructorSameTopic;
        }

        // اگر هنوز کافی نبود
        if ($relatedCourses->count() < 3) {
            // 3. اولویت سوم: دوره‌های هم‌سطح از همان مدرس
            $sameInstructorSameLevel = Course::query()
                ->where('level', $currentCourse->level)
                ->where('created_by', $currentCourse->created_by)
                ->where('id', '!=', $currentCourse->id)
                ->where('status', 'published')
                ->withCount('students')
                ->orderBy('students_count', 'desc')
                ->limit(3 - $relatedCourses->count())
                ->get();

            $relatedCourses = $relatedCourses->merge($sameInstructorSameLevel);
        }

        // اگر هنوز کافی نبود
        if ($relatedCourses->count() < 3) {
            // 4. اولویت چهارم: دوره‌های پرطرفدار در همان زبان
            $sameLanguagePopular = Course::query()
                ->where('language', $currentCourse->language)
                ->where('id', '!=', $currentCourse->id)
                ->where('status', 'published')
                ->withCount('students')
                ->orderBy('students_count', 'desc')
                ->limit(3 - $relatedCourses->count())
                ->get();

            $relatedCourses = $relatedCourses->merge($sameLanguagePopular);
        }

        // اگر باز هم کافی نبود، دوره‌های پرطرفدار عمومی
        if ($relatedCourses->count() < 3) {
            $popularCourses = Course::query()
                ->where('id', '!=', $currentCourse->id)
                ->where('status', 'published')
                ->withCount('students')
                ->orderBy('students_count', 'desc')
                ->limit(3 - $relatedCourses->count())
                ->get();

            $relatedCourses = $relatedCourses->merge($popularCourses);
        }

        return $relatedCourses->take(3);
    }

    public function show_teacher(Teacher $teacher)
    {
        $teacher->load('user');
        return Inertia::render('Teacher/Show', [
            'teacher' => $teacher,
        ]);
    }

}
