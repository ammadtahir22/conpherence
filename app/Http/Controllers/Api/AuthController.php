<?php

namespace App\Http\Controllers\Api;
use App\Models\Site\Company;
use App\Models\Site\Individual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Site\User;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Validator;


class AuthController extends BaseController
{
    /**
     * Create user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response [string] message
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone_number' => 'required',
            'type' => 'required|string',
            'company_name' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->outputJSON('Validation Error.', 400, $validator->errors());
        }


        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'type' => $request->type,
            'ip' => $request->ip(),
            'last_login' => date('Y-m-d H:i:s'),
        ]);

        $user->save();

        if($request->type == 'company')
        {
            Company::create([
                'user_id' => $user->id,
                'name' => $request->company_name,
            ]);
        } else {
            Individual::create([
                'user_id' => $user->id,
            ]);
        }

        $user->save();

        return $this->outputJSON('Successfully created user!', 201,$user);
    }

    /**
     * Login user and create token
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if($validator->fails()){
            return $this->outputJSON('Validation Error.', 400, $validator->errors());
        } else {
            $credentials = request(['email', 'password']);

            if(!Auth::attempt($credentials)){
                return $this->outputJSON('Unauthorized', 401);
            } else {
                $user = $request->user();

                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                $token->save();

                $data = ['access_token' => $tokenResult->accessToken, 'token_type' => 'Bearer'];

                return $this->outputJSON('Logged-in', 200, $data);

            }
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return \Illuminate\Http\Response [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->outputJSON('Successfully logged out', 204);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}