<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\UploadedFile;

class Attachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function transformAvatarFileRequest(UploadedFile $file, array $fileContent): array
    {
        return [
            'url' => env('FILESYSTEM_DISK') === 'local' ? env('APP_URL') . $fileContent['url'] : $fileContent['url'],
            'file_name' => $fileContent['filename'],
            'extension' => $file->getClientOriginalExtension(),
            'type' => 'avatar'
        ];
    }
}
