<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    private const PATH_TO_USER_AVATARS = 'storage/images/users/avatars/';
    private const PATH_TO_DEFAULT_USER_AVATAR = 'public/storage/images/users/avatars/default/defaultUserAvatar.png';

    public function showLoginForm(): string
    {
        return view('auth.signIn');
    }

    public function showSignUpForm(): string
    {
        return view('auth.signUp');
    }

    public function registerUser(RegisterRequest $request)
    {
        $data = $request->validated();
        $avatar = $this->moveUserAvatarToStorage($request);
        $avatar = empty($avatar)
            ? AuthController::PATH_TO_DEFAULT_USER_AVATAR
            : 'public/' . AuthController::PATH_TO_USER_AVATARS . $avatar;

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

    private function moveUserAvatarToStorage(RegisterRequest $request): ?string
    {
        if ($request->hasFile('avatar')) {
            $avatarData = $request->file('avatar');
            $avatarExtension = $avatarData->getClientOriginalExtension();
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
        return null;
    }

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

    public function loginUser(LoginRequest $request)
    {
        return '';
    }

    public function logoutUser()
    {
        auth('web')->logout();

        return redirect()->route('main');
    }
}
