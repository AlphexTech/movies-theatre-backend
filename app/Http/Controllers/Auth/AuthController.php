<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Response Handler
     * @param string message
     * @param number status
     * @param array data
     */
    public function Response($message, $status, $data = null)
    {
        return [
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ];
    }

    public function register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = auth()->login($user);

            $success = $this->Response('Signup successful', 201, $user);

            return response()->json($success);
        } catch (\Throwable $error) {
            $err = $this->Response('There was an error in your request', 400);

            return response()->json($err, 400);
        }
    }
}
