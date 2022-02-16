<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceModel;
use App\Models\SalesModel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = InvoiceModel::with('user', 'customer')->get();
        return view('invoice', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = InvoiceModel::where('id', $id)->with('user', 'customer')->first();
        $invoice_details = array();
        $invoice_details["invoice_by"] = $invoice->user["name"];
        $invoice_details["invoice_to"] = $invoice->customer["name"];
        $invoice_details["sales"] = array();
        $sales = SalesModel::where('invoice_id', $id)->with('product')->get();
        
        $total_price = 0;
        $index = 0;

        foreach ($sales as $sale) {
            $index ++;
            $invoice_details["sales"][$index] = array();
            $invoice_details["sales"][$index]["product_name"] = $sale->product["name"];
            $invoice_details["sales"][$index]["quantity"] = $sale->quantity;
            $invoice_details["sales"][$index]["price"] = $sale->product["sales_price"];
            $invoice_details["sales"][$index]["total_price"] = $invoice_details["sales"][$index]["quantity"] * $invoice_details["sales"][$index]["price"];
            $total_price = ($total_price + $invoice_details["sales"][$index]["total_price"]);
        }
        
        $invoice_details["total_price"] = $total_price;
        return $invoice_details;
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
