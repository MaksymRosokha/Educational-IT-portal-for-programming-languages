<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\CreateLessonRequest;
use App\Http\Requests\admin\DeleteLessonRequest;
use App\Http\Requests\admin\UpdateLessonRequest;
use App\Models\Lesson;
use App\Models\TestResult;
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
        $lessons = $program->lessons()->orderBy('sequence_number')->get();
        $testResult = null;

        if(Auth::check() && $currentLesson->test != null) {
            try {
                $testResult = TestResult::query()->where('user_id', '=', Auth::user()->id)
                    ->where('test_id', '=', $currentLesson->test->id)->first();
            } catch (\Exception $exception){}
        }

        return view('programmingLanguages.programsInProgrammingLanguage.program', [
            'currentLesson' => $currentLesson,
            'program' => $program,
            'lessons' => $lessons,
            'isAdmin' => Auth::check() && Auth::user()->admin === 1,
            'testResult' => $testResult,
        ]);
    }

    public function create(CreateLessonRequest $request)
    {
        $data = $request->validated();
        $countOfLessons = Lesson::query()->where('program_id', '=', $data['programID'])->count();

        $lesson = new Lesson();
        $lesson->program_id = $data['programID'];
        $lesson->sequence_number = $countOfLessons + 1;
        $lesson->title = $data['title'];
        $lesson->content = $data['content'];
        $lesson->save();
    }

    public function update(UpdateLessonRequest $request)
    {
        $data = $request->validated();
        $lesson = Lesson::query()->findOrFail($data['id']);

        $lesson->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    public function delete(DeleteLessonRequest $request)
    {
        $data = $request->validated();
        $lesson = Lesson::query()->findOrFail($data['id']);
        $programID = $lesson->program->id;

        $lesson->delete();

        return redirect()->route('programInProgrammingLanguage', ['programID' => $programID])
            ->with(['result' => "Урок успішно видалено"]);
    }
}
