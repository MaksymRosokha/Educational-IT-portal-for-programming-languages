<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Controller for users
 */
class UserController extends Controller
{
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
        if($data['new_password'] !== $data['confirm_password']){
            $errors[] = 'Новий і повторений пароль не співпадають.';
        }
        if($data['new_password'] === $data['old_password']){
            $errors[] = 'Новий пароль не може бути ідентичним старому.';
        }
        if($errors === []){
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($data['new_password'])
            ]);
            return true;
        } else {
            return response()->json(['errors' => $errors], 422);
        }
    }
}
