<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) abort(404);

        $statuses = $user->statuses()->notReply()->get();

        return view('profile.index', [
            'user' => $user,
            'statuses' => $statuses,
            'authUserIsFriend' => Auth::user()->isFriendWith($user)
        ]);
    }

    public function getEdit()
    {
        return view('profile.edit');
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, [
           'first_name' => 'alpha|max:50',
           'last_name' => 'alpha|max:50',
           'middle_name' => 'alpha|max:50',
        ]);

        Auth::user()->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'middle_name' => $request->input('middle_name'),
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('info', 'Профиль успешно обновлён');
    }
}

