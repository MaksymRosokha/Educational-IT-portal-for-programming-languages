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
        $rememberMe = isset($data['remember_me']);

        if ($request->hasFile('avatar')) {
            $avatar = ImageController::moveImageToStorage(
                imageData: $request->file('avatar'),
                pathToFolder: AuthController::PATH_TO_USER_AVATARS
            );
        } else {
            $avatar = AuthController::DEFAULT_USER_AVATAR;
        }

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
            $request->session()->regenerate();
            auth("web")->login($user, $rememberMe);
        }

        return redirect()->route('main');
    }

    /**
     * Logins user, and if successful, redirects to the main page.
     *
     * @param LoginRequest $request login data
     * @return \Illuminate\Http\RedirectResponse redirect
     */
    public function loginUser(LoginRequest $request)
    {
        $data = $request->validated();
        $rememberMe = isset($data['remember_me']);
        $dataForLogIn = [
            "email" => $data['email'],
            "password" => $data['password'],
        ];

        if (auth('web')->attempt($dataForLogIn, $rememberMe)) {
            $request->session()->regenerate();
            return redirect()->route('main');
        }
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
