<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;

class LoginController extends BaseController
{
    public function login(Request $request) {


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('kenkanekiTouka123')->accessToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success, ' User Login  Successfully');

        }else{


            return $this->sendError('please check your Auth', ['errors'=>'unAuthenticated']);


        }



    }
}
