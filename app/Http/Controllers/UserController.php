<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials']);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token']);
        }
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['user_not_found'], 404);
            }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['error' => 'El token ha expirado']);
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    return response()->json(['error' => 'El token es invalido']);
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json(['error' => 'El token es invalido']);
            } catch (Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
                    return response()->json('error');
            }
            return response()->json(compact('user'));
    }
    public function logout() 
    {
		JWTAuth::parseToken()->invalidate();
		return response()->json(['message' => 'Success logout'], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
	        'name' => 'required|string|max:255',
            'primer_apellido' => 'required|max:255',
            'segundo_apellido' => 'required|max:255',
	        'email' => 'required|string|email|max:255|unique:users',
            'telefono' => 'required|max:13',
	        'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson());
        }

        $user = User::create([
            'name' => $request->get('name'),
            'primer_apellido' => $request->get('primer_apellido'),
            'segundo_apellido' => $request->get('segundo_apellido'),
            'email' => $request->get('email'),
            'telefono' => $request->get('telefono'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }
}