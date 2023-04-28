<?php

namespace App\Http\Controllers;

use App\Http\Requests\user\ChangePasswordRequest;
use App\Http\Requests\user\DeleteUserRequest;
use App\Http\Requests\user\EditProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public function changeUserPassword(ChangePasswordRequest $changePasswordRequest)
    {
        $data = $changePasswordRequest->validated();
        $user = User::query()->findOrFail($data['id']);

        if (Auth::id() != $user->id) {
            return response()->json(['errors' => ['access' => 'Ви не маєте доступу до редагування цього акаунту']],
                403);
        }
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
            $user->update([
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

        if (Auth::id() != $user->id) {
            return response()->json(['errors' => ['access' => 'Ви не маєте доступу до редагування цього акаунту']],
                403);
        }

        $email = $data['email'] ?? $user->email;
        $login = $data['login'] ?? $user->login;
        $name = $data['name'] ?? '';
        $dateOfBirthday = $data['date_of_birthday'] ?? null;
        $aboutMe = $data['about_me'] ?? '';

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
            'avatar' => $avatar,
        ]);
        return redirect()->back();
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

    public function deleteUser(DeleteUserRequest $request)
    {
        $data = $request->validated();
        $id = $data['id'];

        if (Auth::id() == $id || auth('web')->user()->admin === 1) {
            $user = User::query()->findOrFail($id);
            $avatar = $user->avatar;
            if (Storage::exists('public/images/users/avatars/' . $avatar)
                && $avatar !== UserController::DEFAULT_IMAGE) {
                Storage::delete('public/images/users/avatars/' . $avatar);
            }

            $user->delete();
            return true;
        }
        return response()->json(['errors' => ['access' => 'Ви не маєте доступу до видалення цього акаунту']], 403);
    }
}
