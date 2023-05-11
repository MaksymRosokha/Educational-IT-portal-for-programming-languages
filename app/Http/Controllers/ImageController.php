<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadContentImageRequest;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    /**
     * Moves image for content to storage images and returns new image name.
     *
     * @param UploadContentImageRequest $request
     * @return false|string|void new image name
     */
    public static function uploadContentImage(UploadContentImageRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $path = $data['pathToImages'];

            $image = ImageController::moveImageToStorage(
                imageData: $request->file('image'),
                pathToFolder: $path
            );

            return json_encode(['location' => asset($path . $image)]);
        } else {
            abort(419);
        }
    }

    /**
     * Moves image to storage images and returns new image name.
     *
     * @param $imageData
     * @param string $pathToFolder path to storage folder
     * @return string new avatar name
     */
    public static function moveImageToStorage($imageData, string $pathToFolder): string
    {
        $newImageName = ImageController::generateRandomString(20) .
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
    private static function generateRandomString(int $length = 10): string
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
