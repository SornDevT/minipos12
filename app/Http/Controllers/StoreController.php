<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Transection;

class StoreController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

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

    public function index_pos(){

        $sort = \Request::get('sort');
        $perpage = \Request::get('perpage');
        $search = \Request::get('search');

        // -------- ຄົ້ນຫາໄດ້ຫຼາຍ ພິວ
        $store = Store::orderBy('id',$sort)
        ->where(
            function($query) use ($search){
                $query->where('name','LIKE',"%{$search}%")
                ->orWhere('price_sell','LIKE',"%{$search}%");
            }
        )
        ->paginate($perpage)
        ->toArray();

        return array_reverse($store);
    }

    public function edit($id){

        $store = Store::find($id);
        // $store = Store::where('user_id',$id)->get()[0];
        return $store;

    }

    public function add(Request $request){

        try {

            $upload_path = "assets/img";

            if($request->file("image")){
                // ມີຮູບພາບສົ່ງມາ

                $generate_new_name = time().".".$request->image->getClientOriginalExtension(); // ສ້າງຊື່ໄຟລ໌ຂອງຮູບພາບໃໝ່
                $request->image->move(public_path($upload_path),$generate_new_name); // ອັບໂຫຼດຮູບ

            } else {
                // ບໍ່ມິຮູບພາບສົ່ງມາ
                $generate_new_name = "";
            }
            
            // ບັນທຶກຂໍ້ມູນໃໝ່

            $store = new Store([
                'name' => $request->name,
                'image' => $generate_new_name,
                'amount' => $request->amount,
                'price_buy' => $request->price_buy,
                'price_sell' => $request->price_sell,
            ]);

            $store->save();
            $product_id = $store->id;

            // ບັນທຶກການເຄື່ອນໄຫວ ທຸລະກຳຊື້ສິນຄ້າເຂົ້າໃໝ່


            $number='';
            $read_tran = Transection::all()->sortByDesc('id')->take(1)->toArray();
            foreach($read_tran as $new){
                $number = $new['tran_id'];
            }

            if($number!=''){
                $number1 = str_replace("INC","",$number); // INC00001 = 00001
                $number2 = str_replace("EXP","",$number1);
                $number3 = (int)$number2+1; // 1+1 = 2
                $length = 5;
                $number = substr(str_repeat(0,$length).$number3, - $length); //00002
            } else {
                $number3 = 1;
                $length = 5;
                $number = substr(str_repeat(0,$length).$number3, - $length); //00001
            }

            // if($request->acc_type == "income") {
            //     $tnum = "INC"; //INC
            // } elseif($request->acc_type == "expense") {
            //     $tnum = "EXP"; // EXP
            // }

            // return  $new;

            $tran = new Transection([
                "tran_id" => "EXP".$number, // INC00001
                "tran_type" => "expense",
                "product_id" => $product_id,
                "amount" => $request->amount,
                "price" => $request->amount*$request->price_buy,
                "tran_detail" => $request->name,
            ]);
            $tran->save();



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
           $upload_path = "assets/img";

           // ກວດຊອບຮູບພາບ ແລ ລຶບອອກ
           if($request->file("image")){
            
            if($store->image){
                if(file_exists($upload_path."/".$store->image)){
                    unlink($upload_path."/".$store->image);
                }
            }
                
           
                $generate_new_name = time().".".$request->image->getClientOriginalExtension(); // ສ້າງຊື່ໄຟລ໌ຂອງຮູບພາບໃໝ່
                $request->image->move(public_path($upload_path),$generate_new_name); // ອັບໂຫຼດຮູບ


                $store->update([
                    'name' => $request->name,
                    'image' => $generate_new_name,
                    'amount' => $request->amount,
                    'price_buy' => $request->price_buy,
                    'price_sell' => $request->price_sell,
                ]);
            } else {
                // ກໍລະນີບໍ່ອັບໂຫຼດູບພາບ

                if($request->image){
                    $store->update([
                        'name' => $request->name,
                        // 'image' => $generate_new_name,
                        'amount' => $request->amount,
                        'price_buy' => $request->price_buy,
                        'price_sell' => $request->price_sell,
                    ]);
                } else {
                    // ທຳການລຶບຮູບພາບເກົ່າ
                    if($store->image){
                        if(file_exists($upload_path."/".$store->image)){
                            unlink($upload_path."/".$store->image);
                        }
                    }

                    $store->update([
                        'name' => $request->name,
                        'image' => '',
                        'amount' => $request->amount,
                        'price_buy' => $request->price_buy,
                        'price_sell' => $request->price_sell,
                    ]);


                }


            }

           

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
            $upload_path = "assets/img";

            // ທຳການລຶບຮູບພາບເກົ່າ
            if($store->image){
                if(file_exists($upload_path."/".$store->image)){
                    unlink($upload_path."/".$store->image);
                }
            }

            $store->delete(); // ລຶບຂໍ້ມູນ
 
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
