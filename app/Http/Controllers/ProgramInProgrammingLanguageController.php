<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\CreateProgramInProgrammingLanguageRequest;
use App\Http\Requests\admin\DeleteProgramInProgrammingLanguageRequest;
use App\Http\Requests\admin\UpdateProgramInProgrammingLanguageRequest;
use App\Models\ProgramInProgrammingLanguage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgramInProgrammingLanguageController extends Controller
{
    private const PATH_TO_IMAGES = 'storage/images/programsInProgrammingLanguages/';
    private const DEFAULT_IMAGE = 'default/defaultProgramInProgrammingLanguageImage.png';

    /**
     * Shows program by ID
     *
     * @param int $programID program ID
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showProgram($programID)
    {
        if (!intval($programID)) {
            abort(404);
        }

        $program = ProgramInProgrammingLanguage::query()->findOrFail($programID);

        return view(
            'programmingLanguages.programsInProgrammingLanguage.program',
            [
                'program' => $program,
                'lessons' => $program->lessons()->orderBy('sequence_number')->get(),
                'isAdmin' => Auth::check() && Auth::user()->admin === 1,
            ]
        );
    }

    public function create(CreateProgramInProgrammingLanguageRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $image = ImageController::moveImageToStorage(
                imageData: $request->file('image'),
                pathToFolder: ProgramInProgrammingLanguageController::PATH_TO_IMAGES
            );
        } else {
            $image = ProgramInProgrammingLanguageController::DEFAULT_IMAGE;
        }

        $program = new ProgramInProgrammingLanguage();
        $program->programming_language_id = $data['programmingLanguageID'];
        $program->name = $data['name'];
        $program->image = $image;
        $program->description = $data['description'];
        $program->save();
    }

    public function update(UpdateProgramInProgrammingLanguageRequest $request)
    {
        $data = $request->validated();
        $program = ProgramInProgrammingLanguage::query()->findOrFail($data['id']);
        $image = $program->image;

        if ($request->hasFile('image')) {
            if (Storage::exists('public/images/programsInProgrammingLanguages/' . $program->image)
                && $image !== ProgramInProgrammingLanguageController::DEFAULT_IMAGE) {
                Storage::delete('public/images/programsInProgrammingLanguages/' . $program->image);
            }
            $image = ImageController::moveImageToStorage(
                imageData: $request->file('image'),
                pathToFolder: ProgramInProgrammingLanguageController::PATH_TO_IMAGES
            );
        } else {
            if ($image === '') {
                $image = ProgramInProgrammingLanguageController::DEFAULT_IMAGE;
            }
        }

        $program->update([
            'name' => $data['name'],
            'image' => $image,
            'description' => $data['description'],
        ]);
    }

    public function delete(DeleteProgramInProgrammingLanguageRequest $request)
    {
        $data = $request->validated();
        $program = ProgramInProgrammingLanguage::query()->findOrFail($data['id']);
        $programmingLanguageID = $program->programmingLanguage->id;

        if (Storage::exists('public/images/programsInProgrammingLanguages/' . $program->image)
            && $program->image !== ProgramInProgrammingLanguageController::DEFAULT_IMAGE) {
            Storage::delete('public/images/programsInProgrammingLanguages/' . $program->image);
        }
        $program->delete();

        return redirect()->route('programming_language', ['id' => $programmingLanguageID])
            ->with(['result' => "Програму успішно видалено"]);
    }
}