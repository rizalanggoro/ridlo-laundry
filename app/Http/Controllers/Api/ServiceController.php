<?php

namespace App\Http\Controllers\Api;

use App\Models\Laundry;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    /**
     * Display a listing of services for a specific laundry.
     *
     * @param  \App\Models\Laundry  $laundry
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Laundry $laundry)
    {
        // Validasi bahwa laundry_id sesuai dengan pengguna yang login
        if ($laundry->id !== request()->user()->laundry_id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid laundry ID'
            ], 403);
        }

        $services = $laundry->services;

        return response()->json([
            'success' => true,
            'data' => $services->map(function ($service) {
                return [
                    'id' => (string) $service->id,
                    'name' => $service->name,
                    'description' => $service->description,
                    'created_at' => $service->created_at->toISOString(),
                    'updated_at' => $service->updated_at->toISOString(),
                ];
            })
        ], 200);
    }

    /**
     * Store a newly created service for a specific laundry.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Laundry  $laundry
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Laundry $laundry)
    {
        try {
            // Validasi bahwa laundry_id sesuai dengan pengguna yang login
            if ($laundry->id !== $request->user()->laundry_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized: Invalid laundry ID'
                ], 403);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $service = $laundry->services()->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Service created successfully',
                'data' => [
                    'id' => (string) $service->id,
                    'name' => $service->name,
                    'description' => $service->description,
                    'created_at' => $service->created_at->toISOString(),
                    'updated_at' => $service->updated_at->toISOString(),
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create service',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
