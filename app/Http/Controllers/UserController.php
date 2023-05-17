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
        $user->attachments()->create(Attachment::transformAvatarFileRequest($request->validated()['profile_picture'], $file));
        $attachmentUrl = $this->generateAttachmentUrl($user->id);
        $this->createAttachment($user, $attachmentUrl);

        return new UserResource($user);
    }

    public function generateAttachmentUrl(int $userId)
    {
        return env('FRONTEND_URL') . '/user-information/' . $userId;
    }

    public function createAttachment(User $user, string $attachmentUrl)
    {
        return $user->attachments()->create([
            'url' => $attachmentUrl,
            'file_name' => 'qrCode',
            'extension' => 'svg',
            'type' => 'qrcode'
        ]);
    }

    public function showInfo($userId)
    {
        $user = User::findOrFail($userId);
        $attachmentData = $user->attachments;
        $user->attachments;

        $qrCodeDataUri = null;

        foreach ($attachmentData as $attachment) {
            if ($attachment->type === 'qrcode') {
                $qrCode = QrCode::format('svg')->size(200)->generate($attachment->url);
                $qrCodeDataUri = 'data:image/svg+xml;base64,' . base64_encode($qrCode);
            }
        }


        return Response::json(['user' => $user, 'qrCodeDataUri' => $qrCodeDataUri,]);
    }
}
