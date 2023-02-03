<?php

namespace App\Http\Controllers;

use App\Models\User;

/**
 * Controller for users
 */
class UserController extends Controller
{
    /**
     * Shows user profile page.
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
}
