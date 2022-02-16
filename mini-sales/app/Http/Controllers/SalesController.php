<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\SalesModel;
use App\Models\InvoiceModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('create_invoice', $this->fetch());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_report()
    {
        $products = ProductModel::get();
        $product_details = array();
        $index = 0;
        foreach ($products as $product) {
            $index ++;
            $product_details[$index] = array();
            $product_details[$index]['name'] = $product->name;
            $product_details[$index]['stock'] = $product->quantity;
            $product_details[$index]['purchase_price'] = $product->purchase_price;
            $product_details[$index]['sales_price'] = $product->sales_price;
            $product_details[$index]['stock_sales_price'] = $product_details[$index]['stock'] * $product_details[$index]['sales_price'];
            $sold_product = SalesModel::where('product_id', $product->id)->count();
            $product_details[$index]['quantity_sold'] = $sold_product;
        }
        return view('product_stock_report', compact('product_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $row = $request->total_row;
        $invoice_id = null;
        if($row){
            $invoice = InvoiceModel::create([
                'user_id' => Auth::user()->id,
                'customer_id' => $request->customer_id,
            ]);
            $invoice_id = $invoice->id;
        }

        for($i=1; $i<=$row; $i++){
            $product_name = 'product_name'.$row;
            $quantity = 'quantity'.$row;
            $product_id = 'id'.$row;
            if($request->$product_name){
                $request->validate([
                    $product_name => ['required'],
                    $quantity => ['required'],
                    $product_id => ['required'],
                ]);
                SalesModel::create([
                    'product_id' => $request->$product_id,
                    'quantity' => $request->$quantity,
                    'invoice_id' => $invoice_id,
                ]);
                $prev_stock = ProductModel::select('quantity')->where('id', $request->$product_id)->first();
                ProductModel::where('id', $request->$product_id)->update(['quantity' => $prev_stock->quantity - $request->$quantity]);
            }
        }
        return redirect('invoice');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fetch()
    {
        $products = ProductModel::get();
        $customers = CustomerModel::get();
        return compact('customers', 'products');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
