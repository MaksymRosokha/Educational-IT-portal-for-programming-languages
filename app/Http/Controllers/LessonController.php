<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\CreateLessonRequest;
use App\Http\Requests\admin\DeleteLessonRequest;
use App\Http\Requests\admin\UpdateLessonRequest;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    private const PATH_TO_IMAGES = 'storage/images/lessons/';

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
            'isAdmin' => Auth::check() && Auth::user()->admin === 1,
        ]);
    }

    public function create(CreateLessonRequest $request)
    {
        $data = $request->validated();
        $countOfLessons = Lesson::query()->where('program_id', '=', $data['programID'])->count();

        $program = new Lesson();
        $program->program_id = $data['programID'];
        $program->sequence_number = $countOfLessons + 1;
        $program->title = $data['title'];
        $program->content = $data['content'];
        $program->save();
    }

    public function update(UpdateLessonRequest $request)
    {
        $data = $request->validated();
        $program = Lesson::query()->findOrFail($data['id']);

        $program->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    public function delete(DeleteLessonRequest $request)
    {
        $data = $request->validated();
        $program = Lesson::query()->findOrFail($data['id']);

        $program->delete();

        return redirect()->route('main');
    }
}
