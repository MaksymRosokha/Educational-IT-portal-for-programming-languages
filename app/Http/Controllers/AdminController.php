<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\BlockUserRequest;
use App\Http\Requests\admin\loadMoreUsersRequest;
use App\Http\Requests\admin\UnlockUserRequest;
use App\Http\Requests\admin\SearchUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Shows admin panel
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAdminPanel()
    {
        $limit = 20;

        return view('users.admin', [
            'users' => User::query()->limit($limit)->get(),
            'countOfUsers' => User::query()->count(),
        ]);
    }

    public function search(SearchUsersRequest $request)
    {
        $users = [];
        $countOfUsers = 0;
        $limit = 20;

        if (isset($request['searchText'])) {
            $search = $request['searchText'];

            $users = User::query()->where('id', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('login', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->limit($limit)
                ->get();

            $countOfUsers = User::query()->where('id', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('login', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->count();
        } else {
            $users = User::query()->limit($limit)->get();
            $countOfUsers = User::query()->count();
        }

        return view('users.generateUsers', [
            'users' => $users,
            'countOfUsers' => $countOfUsers,
        ]);
    }

    public function loadMoreUsers(loadMoreUsersRequest $request) {
        $data = $request->validated();
        $limit = $data['limit'];
        $search = $data['searchText'];
        $users = [];
        $countOfUsers = 0;

        $users = User::query()->where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->orWhere('login', 'LIKE', '%' . $search . '%')
            ->orWhere('name', 'LIKE', '%' . $search . '%')
            ->limit($limit)
            ->get();
        $countOfUsers = User::query()->where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('email', 'LIKE', '%' . $search . '%')
            ->orWhere('login', 'LIKE', '%' . $search . '%')
            ->orWhere('name', 'LIKE', '%' . $search . '%')
            ->count();


        return view('users.generateUsers', [
            'users' => $users,
            'countOfUsers' => $countOfUsers,
        ]);
    }

    public function changeRole(Request $request)
    {
        $data = $request->all();
        $id = null;
        $admin = null;

        if (!isset($data['id']) || !intval($data['id'])) {
            abort(404);
        }
        if (!Auth::check() || Auth::user()->admin !== 1) {
            abort(403);
        }
        $id = $data['id'];

        if (!isset($data['role'])) {
            abort(404);
        } else {
            if ($data['role'] === 'admin') {
                $admin = 1;
            } else {
                if ($data['role'] === 'user') {
                    $admin = 0;
                } else {
                    abort(404);
                }
            }
        }

        $user = User::query()->findOrFail($id);

        $user->update([
            'admin' => $admin,
        ]);
        return response()->json(['success' => $data]);
    }

    public function blockUser(BlockUserRequest $request)
    {
        $data = $request->validated();
        $user = User::query()->findOrFail($data['id']);

        $user->update([
            'blocked_until' => $data['dateTime'] . ':00',
        ]);
    }

    public function unlockUser(UnlockUserRequest $request)
    {
        $data = $request->validated();
        $user = User::query()->findOrFail($data['id']);

        $user->update([
            'blocked_until' => null,
        ]);
    }
}
