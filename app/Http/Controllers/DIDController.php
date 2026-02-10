<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DIDService;

class DIDController extends Controller
{
    protected $didService;

    public function __construct(DIDService $didService)
    {
        $this->didService = $didService;
    }

    public function createAvatarSpeech(Request $request)
    {
        $request->validate(['text' => 'required|string']);

        $response = $this->didService->generateVideo($request->text);

        if (isset($response['id'])) {
            return response()->json([
                'video_id' => $response['id'],
                'status' => 'processing'
            ]);
        }

        return response()->json(['error' => 'Failed to generate video'], 500);
    }

    public function checkVideoStatus($id)
    {
        $response = $this->didService->getVideoStatus($id);

        if (isset($response['result_url'])) {
            return response()->json([
                'status' => 'completed',
                'video_url' => $response['result_url']
            ]);
        }

        return response()->json(['status' => 'processing']);
    }
}
