<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\CreateProgrammingLanguageRequest;
use App\Http\Requests\admin\DeleteProgrammingLanguageRequest;
use App\Http\Requests\admin\UpdateProgrammingLanguageRequest;
use App\Models\ProgrammingLanguage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $isAdmin = Auth::check() && Auth::user()->admin === 1;

        return view('programmingLanguages.programmingLanguage', [
            'programmingLanguage' => $programmingLanguage,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function create(CreateProgrammingLanguageRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('logo')) {
            $logo = ImageController::moveImageToStorage(
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

    public function update(UpdateProgrammingLanguageRequest $request)
    {
        $data = $request->validated();
        $programmingLanguage = ProgrammingLanguage::query()->findOrFail($data['id']);
        $logo = $programmingLanguage->logo;

        if ($request->hasFile('logo')) {
            if (Storage::exists('public/images/programmingLanguages/logos/' . $programmingLanguage->logo)
                && $logo !== ProgrammingLanguageController::DEFAULT_IMAGE) {
                Storage::delete('public/images/programmingLanguages/logos/' . $programmingLanguage->logo);
            }
            $logo = ImageController::moveImageToStorage(
                imageData: $request->file('logo'),
                pathToFolder: ProgrammingLanguageController::PATH_TO_IMAGES
            );
        } else {
            if ($logo === '') {
                $logo = ProgrammingLanguageController::DEFAULT_IMAGE;
            }
        }

        $programmingLanguage->update([
            'name' => $data['name'],
            'logo' => $logo,
            'description' => $data['description'],
        ]);
    }

    public function delete(DeleteProgrammingLanguageRequest $request)
    {
        $data = $request->validated();
        $programmingLanguage = ProgrammingLanguage::query()->findOrFail($data['id']);

        if (Storage::exists('public/images/programmingLanguages/logos/' . $programmingLanguage->logo)
            && $programmingLanguage->logo !== ProgrammingLanguageController::DEFAULT_IMAGE) {
            Storage::delete('public/images/programmingLanguages/logos/' . $programmingLanguage->logo);
        }
        $programmingLanguage->delete();

        return redirect()->route('main')->with(['result' => "Мову програмування успішно видалено"]);
    }
}
