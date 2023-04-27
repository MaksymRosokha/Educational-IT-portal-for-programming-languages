<?php

namespace App\Http\Controllers;

use App\Http\Requests\profile\ChangePasswordRequest;
use App\Http\Requests\profile\EditProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Controller for users
 */
class UserController extends Controller
{

    private const PATH_TO_IMAGES = 'storage/images/users/avatars/';
    private const DEFAULT_IMAGE = 'default/defaultUserAvatar.png';

    /**
     * Shows user profile page by user login.
     *
     * @param string $login the login of the user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showUserProfile(string $login)
    {
        $user = User::query()->where('login', '=', $login)->firstOrFail();
        $isOwnProfile = false;

        if (!empty(auth('web')->user()->login)) {
            $isOwnProfile = $login === auth('web')->user()->login;
        }

        return view('users.profile', ['user' => $user, 'isOwnProfile' => $isOwnProfile]);
    }

    /**
     * Shows admin panel
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAdminPanel()
    {
        return view('users.admin', ['users' => User::all()]);
    }

    /**
     * Deletes user from database and refreshes admin page
     *
     * @param int $id the ID of the user
     * @return \Illuminate\Http\RedirectResponse redirect to admin panel
     */
    public function deleteUser(int $id)
    {
        User::query()->findOrFail($id)->delete();
        return redirect()->route('admin');
    }

    public function changeUserPassword(ChangePasswordRequest $changePasswordRequest)
    {
        $data = $changePasswordRequest->validated();
        $errors = [];

        if (!Hash::check($data['old_password'], auth('web')->user()->password)) {
            $errors[] = 'Старий пароль введений не вірно.';
        }
        if ($data['new_password'] !== $data['confirm_password']) {
            $errors[] = 'Новий і повторений пароль не співпадають.';
        }
        if ($data['new_password'] === $data['old_password']) {
            $errors[] = 'Новий пароль не може бути ідентичним старому.';
        }
        if ($errors === []) {
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($data['new_password']),
            ]);
            return true;
        } else {
            return response()->json(['errors' => $errors], 422);
        }
    }

    public function editProfile(EditProfileRequest $request)
    {
        $data = $request->validated();
        $user = User::query()->findOrFail($data['id']);

        $email = $data['email'] ?? $user->email;
        $login = $data['login'] ?? $user->login;
        $name = $data['name'] ?? $user->name;
        $dateOfBirthday = $data['date_of_birthday'] ?? $user->date_of_birthday;
        $aboutMe = $data['about_me'] ?? $user->about_me;

        $avatar = $user->avatar;
        if ($request->hasFile('avatar')) {
            if (Storage::exists('public/images/users/avatars/' . $avatar)
                && $avatar !== UserController::DEFAULT_IMAGE) {
                Storage::delete('public/images/users/avatars/' . $avatar);
            }
            $avatar = $this->moveImageToStorage(
                imageData: $request->file('avatar'),
                pathToFolder: UserController::PATH_TO_IMAGES
            );
        }

        $user->update([
            'email' => $email,
            'login' => $login,
            'name' => $name,
            'date_of_birthday' => $dateOfBirthday,
            'about_me' => $aboutMe,
            'avatar' => $avatar
        ]);
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
