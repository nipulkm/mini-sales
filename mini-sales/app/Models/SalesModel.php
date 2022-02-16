<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesModel extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'quantity', 'invoice_id'];

    public function invoice(){
        return $this->belongsTo('App\Models\InvoiceModel', 'invoice_id');
    }

    public function product(){
        return $this->belongsTo('App\Models\ProductModel', 'product_id');
    }
}
