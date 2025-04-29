<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role' => 'required|string|in:owner,staff',
            'laundry_id' => 'required|exists:laundries,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = Hash::make($input["password"]);
        $user = User::create($input);
        $tokenName = $user->name . '-' . $user->role . '-android-laundry-' . Carbon::now()->translatedFormat('d-m-Y-H-i-s');

        $success = [
            'token' => $user->createToken($tokenName)->plainTextToken,
            'name' => $user->name,
            'role' => $user->role,
            'laundry_id' => $user->laundry_id
        ];

        return $this->sendResponse($success, 'User Berhasil Registrasi');
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors());
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $tokenName = $user->name . '-' . $user->role . '-android-laundry-' . Carbon::now()->translatedFormat('d-m-Y-H-i-s');

            $success = [
                'token' => $user->createToken($tokenName)->plainTextToken,
                'name' => $user->name,
                'role' => $user->role,
                'laundry_id' => $user->laundry_id
            ];

            return $this->sendResponse($success, 'User Berhasil Login');
        } else {
            return $this->sendError('Gagal Login', ['error' => 'Tidak Dapat Izin']);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->sendResponse([], 'User Berhasil Logout');
        } catch (\Throwable $th) {
            return $this->sendError('Gagal Logout', ['error' => $th->getMessage()]);
        }
    }

    public function getUser(Request $request)
    {
        try {
            $user = $request->user()->load('laundry');

            // Format respons
            $response = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'laundry' => $user->laundry ? [
                    'id' => $user->laundry->id,
                    'name' => $user->laundry->name,
                ] : null,
                'email_verified_at' => $user->email_verified_at?->toISOString(),
                'created_at' => $user->created_at->toISOString(),
                'updated_at' => $user->updated_at->toISOString(),
            ];

            return $this->sendResponse($response, 'User retrieved successfully');
        } catch (\Exception $e) {
            \Log::error('Get user error: ' . $e->getMessage());
            return $this->sendError('Error retrieving user', ['error' => $e->getMessage()], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();

            // Log request data
            Log::info('Update request data:', $request->all());

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
                'password' => 'sometimes|required',
                // 'role' => 'sometimes|required|string|in:owner,staff',
                // 'laundry_id' => 'sometimes|required|exists:laundries,id',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error', $validator->errors());
            }

            // if (!$request->hasAny(['name', 'email', 'password', 'role', 'laundry_id'])) {
            //     return $this->sendError('No changes detected', []);
            // }
            if (!$request->hasAny(['name', 'email', 'password'])) {
                return $this->sendError('No changes detected', []);
            }

            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }

            // if ($request->has('role')) {
            //     $user->role = $request->role;
            // }

            // if ($request->has('laundry_id')) {
            //     $user->laundry_id = $request->laundry_id;
            // }

            if (!$user->isDirty()) {
                return $this->sendError('No changes detected', []);
            }

            $user->save();

            return $this->sendResponse($user, 'Profile updated successfully');
        } catch (\Throwable $th) {
            return $this->sendError('Error updating profile', ['error' => $th->getMessage()]);
        }
    }
}
