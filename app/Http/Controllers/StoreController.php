<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    //

    public function index(){

        $sort = \Request::get('sort');
        $perpage = \Request::get('perpage');
        $search = \Request::get('search');

        // -------- ຄົ້ນຫາໄດ້ຫຼາຍ ພິວ
        $store = Store::orderBy('id',$sort)
        ->where(
            function($query) use ($search){
                $query->where('name','LIKE',"%{$search}%")
                ->orWhere('price_buy','LIKE',"%{$search}%");
            }
        )
        ->paginate($perpage)
        ->toArray();

        return array_reverse($store);

        // --------------- ຄົ້ນຫາ ພິວດຽວ
        // $store = Store::orderBy('id',$sort)
        // ->where('name','LIKE',"%{$search}%")
        // ->paginate($perpage)
        // ->toArray();
        // return array_reverse($store);

        //---------------------

        // $store = Store::orderBy('id','asc')->get();
        // return $store;
    }

    public function edit($id){

        $store = Store::find($id);
        // $store = Store::where('user_id',$id)->get()[0];
        return $store;

    }

    public function add(Request $request){

        try {
            
            // ບັນທຶກຂໍ້ມູນໃໝ່

            $store = new Store([
                'name' => $request->name,
                'image' => '',
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]);

            $store->save();

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

    public function update($id, Request $request){

        try {
            
          
           $store = Store::find($id);
           $store->update([
                'name' => $request->name,
                'image' => '',
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
           ]);

            $success = true;
            $message = 'ອັບເດດຂໍ້ມູນສຳເລັດ!';

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

    public function delete($id){
        try {
            
          
            $store = Store::find($id);
            $store->delete();
 
             $success = true;
             $message = 'ລຶບຂໍ້ມູນສຳເລັດ!';
 
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
