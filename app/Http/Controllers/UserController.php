<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\Attachment;
use App\Models\User;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function store(UserStoreRequest $request)
    {
        $user = User::create(Arr::except($request->validated(), ['profile_picture']));
        $file = $user->uploadAvatar($request->validated()['profile_picture']);
        $user->attachments()->create(Attachment::transformAvatarFileRequest($request->validated()['profile_picture'], $file));
        return new UserResource($user);
    }
}
