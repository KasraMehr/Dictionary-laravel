<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\Quiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class CourseLessonController extends Controller
{
    public function index(Course $course): Response
    {
        $lessons = $course->course_lessons()
            ->orderBy('order')
            ->get();

        return Inertia::render('Teacher/CourseLessons/Index', [
            'course' => $course,
            'lessons' => $lessons,
        ]);
    }

    public function create(Course $course): Response|ResponseFactory
    {
        $quizzes = Quiz::all();

        return inertia('Teacher/CourseLessons/Create', [
            'course' => $course,
            'quizzes' => $quizzes,
            'skills' => CourseLesson::SKILLS,
        ]);
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'skills' => 'required|array',
            'skills.*' => 'in:'.implode(',', array_keys(CourseLesson::SKILLS)),
            'content' => 'required|array',
            'quiz_id' => 'nullable|exists:quizzes,id',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-flv,video/webm|max:102400',
        ]);

        if ($request->hasFile('video')) {
            $file = $request->file('video');

            // تولید نام منحصر به فرد برای فایل
            $fileName = 'lessons/videos/' . Str::uuid() . '.' . $file->getClientOriginalExtension();

            // آپلود به Liara Bucket
            Storage::disk('s3')->put($fileName, file_get_contents($file));

            // دریافت لینک دائمی
            $validated['video_url'] = Storage::disk('s3')->url($fileName);
        }

        $course->course_lessons()->create($validated);

        return redirect()->route('teacher.courses.show', $course)
            ->with('success', 'درس جدید با موفقیت ایجاد شد');
    }

    public function edit(Course $course, CourseLesson $lesson)
    {
        $quizzes = Quiz::all();

        return inertia('Teacher/CourseLessons/Edit', [
            'course' => $course,
            'lesson' => $lesson,
            'quizzes' => $quizzes,
            'skills' => CourseLesson::SKILLS,
        ]);
    }

    public function update(Request $request, Course $course, CourseLesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'skills' => 'required|array',
            'skills.*' => 'in:'.implode(',', array_keys(CourseLesson::SKILLS)),
            'content' => 'required|array',
            'quiz_id' => 'nullable|exists:quizzes,id',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-flv,video/webm|max:102400',
            'should_delete_video' => 'nullable|boolean',
        ]);

        // مدیریت حذف ویدیو
        if ($request->should_delete_video && $lesson->video_url) {
            $this->deleteVideo($lesson->video_url);
            $validated['video_url'] = null;
        }

        // آپلود ویدیوی جدید
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $fileName = 'lessons/videos/' . Str::uuid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('s3')->put($fileName, file_get_contents($file));
            $validated['video_url'] = Storage::disk('s3')->url($fileName);
        }

        $lesson->update($validated);

        return redirect()->route('teacher.courses.show', $course)
            ->with('success', 'درس با موفقیت به‌روزرسانی شد');
    }

    protected function deleteVideo($videoUrl): void
    {
        try {
            $path = parse_url($videoUrl, PHP_URL_PATH);
            $filePath = ltrim($path, '/');

            if (Storage::disk('s3')->exists($filePath)) {
                Storage::disk('s3')->delete($filePath);
            }
        } catch (\Exception $e) {
            \Log::error('Error deleting video from bucket: ' . $e->getMessage());
        }
    }
}
