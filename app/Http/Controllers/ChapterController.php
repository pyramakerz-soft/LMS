<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index($unitId)
    {


        $userAuth = auth()->guard('student')->user();
        if ($userAuth) {
            $unit = Unit::with('chapters')->findOrFail($unitId);
            return view('pages.student.chapter.index', compact('unit', 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }
    public function showLessons($chapterId)
    {
        $userAuth = auth()->guard('student')->user();
        if ($userAuth) {
            $chapter = Chapter::with(['lessons.ebooks'])->findOrFail($chapterId);
            return view('pages.student.lesson.index', compact('chapter', 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }
    public function viewEbooks($lessonId)
    {
        $userAuth = auth()->guard('student')->user();

        // Fetch the lesson along with its related eBooks
        $lesson = Lesson::with('ebooks')->findOrFail($lessonId);

        // Pass the lesson and authenticated user to the view
        return view('pages.student.lesson.ebooks', compact('lesson', 'userAuth'));
    }
}
