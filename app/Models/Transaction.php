<?php

namespace App\Models;

use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable =['id','customer','total_amount'];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public $incrementing = false;
}
