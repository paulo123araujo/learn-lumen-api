<?php

namespace APP\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends BaseController
{
    public function index(Request $request)
    {
        $users = User::all()->orderBy('created_at', 'desc')->paginate(16);
        return $this->sendResponse(
            UserResource::collection($users),
            'Data loaded successfully.'
        );
    }

    public function show(Request $request, User $user)
    {
        return $this->sendResponse(
            $user,
            'Data loaded successfully.'
        );
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users|max:120',
            'login' => 'required|unique:users|max:50',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->login = $request->login;
            $user->password = Hash::make($request->password);

            $user->save();

            return $this->sendResponse(
                $user,
                'User saved successfully.',
                201
            );
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->only('name'));
        return $this->sendResponse($user, 'User updated successfully.');
    }

    public function remove(Request $request, User $user)
    {
        $user->delete();
        return response()->noContent();
    }
}
