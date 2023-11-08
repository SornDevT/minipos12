<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;

class TransectionController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function add(Request $request){

        try {


            $tran = new Transection();

            // $tran->save();

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
}
