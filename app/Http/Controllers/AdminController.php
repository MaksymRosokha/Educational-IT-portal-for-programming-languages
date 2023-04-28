<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Shows admin panel
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAdminPanel()
    {
        return view('users.admin', ['users' => User::all()]);
    }

    public function changeRole(Request $request)
    {
        $data = $request->all();
        $id = null;
        $admin = null;

        if (!isset($data['id']) || !intval($data['id'])) {
            abort(404);
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
}
