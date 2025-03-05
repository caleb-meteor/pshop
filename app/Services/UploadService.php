<?php

namespace App\Services;

use Caleb\Practice\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService extends Service
{
    public function upload(UploadedFile $file)
    {
        $path = $file->store('order_vouchers', 'public');
        return Storage::disk('public')->url($path);
    }
}
