<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\CreateUserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::withTrashed()->get());
    }

    public function store(CreateUserRequest $request)
    {
        $user = User::create(
            $request->only(['first_name', 'last_name', 'email'])
            +
            ['password' => User::DEFAULT_USER_PASSWORD]
        );
        $user->assignRole($request->role ? $request->role : User::ROLES['USER']);

        // TODO: Can send email to the user also

        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $avatar = $request->file('avatar');

        $data = [
            'first_name' => $request->first_name ? $request->first_name : $user->first_name,
            'last_name' => $request->last_name ? $request->last_name : $user->last_name,
            'email' => $request->email ? $request->email : $user->email,
        ];

        if ($avatar) {
            $fileName = $user->generateAvatarName($avatar);
            $avatar->move(User::AVATAR_PATH, $fileName);

            $data['avatar'] = User::AVATAR_PATH . $fileName;
        }

        $user->update($data);

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
