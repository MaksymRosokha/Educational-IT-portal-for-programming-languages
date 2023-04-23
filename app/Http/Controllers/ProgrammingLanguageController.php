<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProgrammingLanguageRequest;
use App\Models\Lesson;
use App\Models\ProgramInProgrammingLanguage;
use App\Models\ProgrammingLanguage;

/**
 * This class is controller for programming languages
 */
class ProgrammingLanguageController extends Controller
{
    private const PATH_TO_IMAGES = 'storage/images/programmingLanguages/logos/';
    private const DEFAULT_IMAGE = 'default/defaultProgrammingLanguageLogo.png';

    /**
     * Shows one programming language page by ID.
     *
     * @param int $id programming language ID
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showOneLanguage($id)
    {
        $programmingLanguage = ProgrammingLanguage::query()->findOrFail($id);
        return view('programmingLanguages.programmingLanguage', ['programmingLanguage' => $programmingLanguage]);
    }

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
            ]
        );
    }

    public function create(CreateProgrammingLanguageRequest $request){
        $data = $request->validated();
        if ($request->hasFile('logo')) {
            $logo = $this->moveImageToStorage(
                imageData: $request->file('logo'),
                pathToFolder: ProgrammingLanguageController::PATH_TO_IMAGES
            );
        } else {
            $logo = ProgrammingLanguageController::DEFAULT_IMAGE;
        }

        $programmingLanguage = new ProgrammingLanguage();
        $programmingLanguage->name = $data['name'];
        $programmingLanguage->logo = $logo;
        $programmingLanguage->description = $data['description'];
        $programmingLanguage->save();
    }

    private function moveImageToStorage($imageData, string $pathToFolder): string
    {
        $newImageName = $this->generateRandomString(20) .
            '=' .
            date('Y-m-d~H.i.s') .
            '.' .
            $imageData->getClientOriginalExtension();

        $imageData->move(
            public_path($pathToFolder),
            $imageData->getClientOriginalName()
        );
        rename(
            public_path($pathToFolder) . $imageData->getClientOriginalName(),
            public_path($pathToFolder) . $newImageName
        );

        return $newImageName;
    }

    /**
     * Generates random string.
     *
     * @param int $length the length of the string to be generated
     * @return string generated string
     */
    private function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
