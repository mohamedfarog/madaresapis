<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function test()
    {
        return Auth::user();
    }
    public function login(Request $request)
    {
        $user = User::with(['usertype'])->where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $token = $user->createToken('Madares')->plainTextToken;
                $accessToken = ['token' => $token];
                return $this->onSuccess([$user, $accessToken]);
            } else {
                $response = "Password mismatch";
                return $this->onError($response);
            }
        } else {
            $response = "User does not exist";
            return $this->onError($response);
        }
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }


    public function loginV2(Request $request)
    {
      
      
        $credentials = $request->only('email', 'password');
        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return $this->onError($validator->errors()->all());
          
        }
        // Request is validated
        //Creat token
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->onError(
                    'Login credentials are invalid.',
                );
            }
        } catch (JWTException $e) {
            // return $credentials;
            return $this->onError('Login credentials are invalid.');
        }
        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => Auth::user(),
        ]);
    }

    function facebookAuth($accessToken)
    {
        try {

            $user = Socialite::driver('facebook')->userFromToken($accessToken);
            if ($user) {

                $fUser = User::where('facebook_id', $user->id)->first();
                if ($fUser) {
                    $token = JWTAuth::fromUser($fUser);
                    return [
                        'status' => true,
                        'token' => $token,
                        'user' => $fUser,
                    ];
                } else {
                    $fUser = new User();
                    if ($user->email)
                        $email = $user->email;
                    else {
                        $email = $user->name . '@facebook.com';
                    }
                    $fUser->email = $email;
                    // $fUser->name = $user->name;
                    $fUser->facebook_id = $user->id;
                    $fUser->save();
                    $token = JWTAuth::fromUser($fUser);
                    return [
                        'status' => true,
                        'token' => $token,
                        'user' => $fUser,
                    ];
                }
            } else {
                return $this->onError("access token not valid");
            }
        } catch (Exception $e) {
            return $e;
            //return $this->onError("access token not valid exc");
        }
    }

    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loginType' => 'required',
            'accessToken' => 'required'
        ]);
        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        switch ($request->loginType) {
            case 'facebook':
                $data = $this->facebookAuth($request->accessToken);
                break;
        }

        return $data;
    }

    public function testFace(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->userFromToken("EAATbOqwznZBEBAF9XZCmxE7YGMbdehBwbN0O829foDczGdGjlwlSgKC5UpnZBipxtEnIZBZCJiBXQ5hRPxh2rAhDGVZCi136mq2MGalLaGLqUogkZCGt6hYoUocrCoT2hSmDZB1T79Q0qRCjKjpT9BXRBLZAQucZAEEczgrx3QHpUjzRPJsZBZC369VHRiVhwTfaYh31dKxDVY9MY4lQOtaaKkvw");
            if ($user) {
                return json_encode($user);
            }
        } catch (Exception $e) {
            return $this->onError("access token not valid");
        }
    }
}
