<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = $request->user()->students()
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.profile_photo_path',
                'teacher_student.level',
                'teacher_student.created_at',
            ])
            ->latest('teacher_student.created_at')
            ->paginate(12);

        // برای دیباگینگ:
        //        \Log::debug('Students data:', $students->toArray());
        //        dd($students); // فقط برای تست موقت

        return inertia('Teacher/Students/Index', [
            'students' => $students,
        ]);
    }

    public function show(Request $request, User $student)
    {
        // بررسی آیا دانشجو واقعاً متعلق به این استاد است
        if (! $request->user()->students()->where('student_id', $student->id)->exists()) {
            abort(403);
        }

        $student->load([
            'teachers' => function ($query) use ($request) {
                $query->where('teacher_id', $request->user()->id)
                    ->select(['users.id', 'users.name', 'teacher_student.level', 'teacher_student.created_at']);
            },
        ]);

        return inertia('Teacher/Students/Show', [
            'student' => $student,
            'pivot' => $student->teachers[0]->pivot ?? null,
        ]);
    }

    public function updateLevel(Request $request, User $student): RedirectResponse
    {
        $request->validate([
            'level' => 'required|in:beginner,intermediate,advanced',
        ]);

        $request->user()->students()->updateExistingPivot($student->id, [
            'level' => $request->level,
        ]);

        return back()->with('success', 'سطح دانشجو با موفقیت به‌روزرسانی شد');
    }

    public function addNote(Request $request, User $student): RedirectResponse
    {
        $request->validate([
            'note' => 'required|string|max:500',
        ]);

        $request->user()->students()->updateExistingPivot($student->id, [
            'notes' => $request->note,
        ]);

        return back()->with('success', 'یادداشت با موفقیت اضافه شد');
    }
}
