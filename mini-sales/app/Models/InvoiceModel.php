<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'customer_id'];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function customer(){
        return $this->belongsTo('App\Models\CustomerModel', 'customer_id');
    }
}
