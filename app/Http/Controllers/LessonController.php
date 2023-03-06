<?php

namespace App\Http\Controllers;

use App\Models\Lesson;

class LessonController extends Controller
{

    /**
     * Returns the lesson by its ID.
     *
     * @param int $lessonID ID of the lesson
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLesson($lessonID)
    {
        if (!intval($lessonID)) {
            abort(404);
        }
        $currentLesson = Lesson::query()->findOrFail($lessonID);
        $program = $currentLesson->program()->first();

        return view('programmingLanguages.programsInProgrammingLanguage.program', [
            'currentLesson' => $currentLesson,
            'program' => $program,
            'lessons' => $program->lessons()->orderBy('sequence_number')->get(),
        ]);
    }
}
