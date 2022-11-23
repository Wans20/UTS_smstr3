<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = ['id','transaction_id','product_id','quantity','amount',];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public $incrementing = false;

}
