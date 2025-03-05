<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Foundation\FileService;
use App\Services\UploadService;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Caleb 2025/3/4
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'image|max:10240',
        ]);

        return $this->success(
            ['url' => UploadService::instance()->upload($request->file('file'))]
        );
    }
}
