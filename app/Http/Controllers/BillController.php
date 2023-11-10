<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Bill_list;

class BillController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function print_bill($bill_id){

        $bill = Bill::where("bill_id",$bill_id)->get();
        $bill_list = Bill_list::where("bill_id",$bill_id)->get();

        return view('bill')->with("bill",$bill)->with("bill_list",$bill_list);
    }
}
