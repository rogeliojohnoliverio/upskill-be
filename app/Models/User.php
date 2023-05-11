<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function avatar(): MorphOne
    {
        return $this->morphOne(Image::class, 'attachable')->oldestOfMany();
    }

    public function uploadAvatar(UploadedFile $avatar): array
    {
        $filename = Str::random(40) . '.' . $avatar->getClientOriginalExtension();
        Storage::put('public/' . $filename, file_get_contents($avatar));
        return [
            "filename" => $filename,
            "url" => Storage::url('public/' . $filename)
        ];
    }
}
