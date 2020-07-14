<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SessionController extends BaseController
{

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|max:150',
            'login' => 'string|max:50',
            'password' => 'required'
        ]);

        if ($request->email) {
            $credentials = $request->only('email', 'password');
        } else {
            $request->password = Hash::make($request->password);
            $credentials = $request->only('login', 'password');
        }

        if (!$authorized = Auth::attempt($credentials)) {
            return $this->sendError('Incorrect data.', [], 401);
        }

        return $this->sendResponse([
            'token' => $authorized,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 'User logged in.', 200);
    }

    public function remove(Request $request)
    {
        Auth::logout();
        return response()->noContent();
    }
}
