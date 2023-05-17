<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\Attachment;
use App\Models\User;
use Illuminate\Support\Arr;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

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
        $qrCode = QrCode::format('svg')->size(200)->generate(env('FRONTEND_URL') . "/user-information/{$user->id}");
        $qrCodeFile = $user->uploadQRCode($qrCode);
        $user->attachments()->create(Attachment::transformAvatarFileRequest($request->validated()['profile_picture'], $file));
        $user->attachments()->create(Attachment::transformQRCodeFileRequest($qrCodeFile));
        return new UserResource($user);
    }
}
