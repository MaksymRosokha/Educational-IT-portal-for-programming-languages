<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    /**
     * Returns the lesson by its ID.
     *
     * @param int $lessonID ID of the lesson
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLesson($lessonID){
        if(!intval($lessonID)){
            abort(404);
        }
        return view('lessons.lesson', ['lesson' => Lesson::query()->findOrFail($lessonID)]);
    }
}
