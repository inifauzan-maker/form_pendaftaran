<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class SchoolController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $path = resource_path('data/school.json');

        if (! file_exists($path)) {
            return response()->json([]);
        }

        $schools = json_decode(file_get_contents($path), true) ?? [];

        return response()->json($schools);
    }
}
