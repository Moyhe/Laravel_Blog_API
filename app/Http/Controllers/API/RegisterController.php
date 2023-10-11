<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

class RegisterController extends BaseController
{
    public function register(Request $request) {

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError(' Oops!! Validate Error', $validator->errors());
        }
       $input = $request->all();
       $input['password'] = Hash::make($input['password']);
       $user = User::create($input);
       $success['token'] = $user->createToken('kenkanekiTouka123')->accessToken;
       $success['name'] = $user->name;

       return $this->sendResponse($success, 'User Created Successfully');

    }
}
