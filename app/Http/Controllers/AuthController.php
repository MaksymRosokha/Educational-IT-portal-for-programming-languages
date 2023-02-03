<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

/**
 * Controller for authentication
 */
class AuthController extends Controller
{
    /**
     * Path to folder of user avatars
     */
    private const PATH_TO_USER_AVATARS = 'storage/images/users/avatars/';
    /**
     * Default user avatar
     */
    private const DEFAULT_USER_AVATAR = 'default/defaultUserAvatar.png';

    /**
     * Shows login form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view('auth.signIn');
    }

    /**
     * Shows sign up form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showSignUpForm()
    {
        return view('auth.signUp');
    }

    /**
     * Registers user and redirects to main page
     *
     * @param RegisterRequest $request register data
     * @return \Illuminate\Http\RedirectResponse redirect to main page
     */
    public function registerUser(RegisterRequest $request)
    {
        $data = $request->validated();
        $avatar = $this->moveUserAvatarToStorage($request);

        $user = User::create([
            'email' => $data['email'],
            'login' => $data['login'],
            'password' => bcrypt($data['password']),
            'name' => $data['name'],
            'date_of_birthday' => $data['date_of_birthday'],
            'about_me' => $data['about_me'],
            'avatar' => $avatar,
        ]);

        if ($user) {
            auth("web")->login($user);
        }

        return redirect()->route('main');
    }

    /**
     * Moves user`s avatar to storage and returns new avatar name or default.
     *
     * @param RegisterRequest $request register data
     * @return string new avatar name or default
     */
    private function moveUserAvatarToStorage(RegisterRequest $request): string
    {
        if ($request->hasFile('avatar')) {
            $avatarData = $request->file('avatar');
            $newAvatarName = $this->generateRandomString(20) .
                '=' .
                date('Y-m-d H.i.s') .
                '.' .
                $avatarData->getClientOriginalExtension();

            $request->file('avatar')->move(
                public_path(AuthController::PATH_TO_USER_AVATARS),
                $request->file('avatar')->getClientOriginalName()
            );
            rename(
                public_path(AuthController::PATH_TO_USER_AVATARS) . $avatarData->getClientOriginalName(),
                public_path(AuthController::PATH_TO_USER_AVATARS) . $newAvatarName
            );

            return $newAvatarName;
        }
        return AuthController::DEFAULT_USER_AVATAR;
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

    /**
     * Logins user, and if successful, redirects to the main page.
     *
     * @param LoginRequest $request login data
     * @return \Illuminate\Http\RedirectResponse redirect
     */
    public function loginUser(LoginRequest $request)
    {
        if (auth('web')->attempt($request->validated())) {
            return redirect()->route('main');
        };
        return redirect()->route('login')->withErrors(['email' => 'email або пароль введені не правильно']);
    }

    /**
     * Logouts user and redirects.
     *
     * @return \Illuminate\Http\RedirectResponse redirect
     */
    public function logoutUser()
    {
        auth('web')->logout();
        return redirect()->route('main');
    }
}
