<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function show(Attachment $attachment)
    {
        return 'data:image/svg+xml;base64,' . base64_encode(Storage::get('public/' . $attachment->file_name));
    }
}
