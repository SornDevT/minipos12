<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use JWTAuth;

class UserController extends Controller
{
    //

    public function register(Request $request){

        try {
            
            // ບັນທຶກຂໍ້ມູນ User ໃໝ່
            $user = new User([
                'name' => $request->from_user_name,
                'email' => $request->from_email,
                'password' => hash::make($request->from_password)
            ]);

            $user->save();

            $success = true;
            $message = 'ບັນທຶກຂໍ້ມູນສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            "success" => $success,
            "message" => $message
        ];

        return response()->json($response);

    }

    public function login(Request $request){

        $user_login = [
            'email'=>$request->login_email,
            'password'=>$request->login_password
        ];

        $token = JWTAUTH::attempt($user_login);
        $user = Auth::user();

        if($token){

            return response()->json([
                'success' => true,
                'message' => 'ສຳເລັດ!',
                'user' => $user,
                'token' => $token
            ]);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'ລະຫັດຜ່ານ ຫຼືອີເມວລ໌ບໍ່ຖຶກຕ້ອງ!',
            ]);

        }

    }

    public function logout(){


        Auth::logout();
        return response()->json([
            'success' => true,
            'message' => 'ສຳເລັດ!',
        ]);

        // $token = Auth::getToken();
        // $invalidate = Auth::invalidate($token);
        // if($invalidate){
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'ສຳເລັດ!',
        //     ]);
        // }

    }

}
