<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transection extends Model
{
    use HasFactory;
    protected $fillable = [
        'tran_id',
        'tran_type',
        'product_id',
        'amount',
        'price',
        'tran_detail'
    ];
}
