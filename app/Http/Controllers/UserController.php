<?php

namespace App\Http\Controllers;

use App\Models\User;

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
        $isOwnProfile = $login === auth('web')->user()->login;
        return view('users.profile', ['user' => $user, 'isOwnProfile' => $isOwnProfile]);
    }

    /**
     * Shows admin panel
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAdminPanel() {
        return view('users.admin', ['users' => User::all()]);
    }

    /**
     * Deletes user from database and refreshes admin page
     *
     * @param int $id the ID of the user
     * @return \Illuminate\Http\RedirectResponse redirect to admin panel
     */
    public function deleteUser(int $id){
        User::query()->findOrFail($id)->delete();
        return redirect()->route('admin');
    }
}
