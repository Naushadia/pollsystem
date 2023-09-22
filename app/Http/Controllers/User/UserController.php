<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function random_bytes;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['register','login']]);
    }
    public function register(Request $request)
    {
        try {
            $this->validate($request, [
                'first_name' => 'required|min:2|max:10|string',
                'last_name' => 'min:2|max:10|string',
                'email' => 'required|email|unique:users,email',
                "username" => 'required|unique:users,username|string',
                'password' => 'required|min:8|max:20',
            ]);
            $user = new User();
            $user->username = $request->username;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            // $token = base64_encode(random_bytes(64));

            $user->save();
            $token = $user->createToken('auth', ['user:auth'], now()->addHours(24));

            return response()->json(['status' => 200, 'data' => $user, 'token' => $token]);
        } catch (\Exception $ex) {
            return response()->json(['status' => 500, 'message' => $ex->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        try {
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required',
            ]);
            $credentials = $request->all();
            if (Auth::guard('web')->attempt($credentials)) {
                $user = auth()->user();
                $id = auth()->user()->id;
                $user->tokens()->where('tokenable_id', $id)->delete();
                $token = $user->createToken('auth', ['user:auth'], now()->addHours(24));
                return response()->json(['status' => 200, 'message' => 'Logged In successfully', 'data' => $user, 'token' => $token]);
            } else {
                return response()->json(['status' => 400, 'message' => 'Please try again']);
            }
        } catch (\Exception $ex) {
            return response()->json(['status' => 500, 'message' => $ex->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('sanctum')->user()->tokens()->delete();
        // $request->user()->currentAccessToken()->delete();
        $keys = ['laravel_session', 'XSRF-TOKEN'];

        $key2 = ['cookie', 'authorization'];

        foreach ($keys as $key) {

            $request->cookies->remove($key);

        }

        foreach ($key2 as $key) {
            $request->headers->remove($key);
        }

        return response()->json(['status' => 200, 'message' => 'logged out successfully']);
    }

    public function editprofile(Request $request)
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $user->update($request->all());
        return response()->json(['status' => 200, 'data' => $user]);
    }

    public function getprofile(Request $request)
    {
        $userId = Auth::user()->id;
        $user = User::with('questions','poll','participate')->find($userId);
        return response()->json(['status' => 200, 'data' => $user]);
    }
}
