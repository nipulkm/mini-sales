<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 form-group text-center" style="width:60%; margin:0 auto;">
                    <div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <a href="create-invoice"><button type="button" class="btn btn-success">Create New Invoice</button></a>
                    <br><br>
                    <table class="table">
                        <thead>
                          <tr>
                            <th>Invoice Id</th>
                            <th>User Name</th>
                            <th>Customer Name</th>
                            <th>Details</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{$invoice->id}}</td>
                                    <td>{{$invoice->user['name']}}</td>
                                    <td>{{$invoice->customer['name']}}</td>
                                    <td>
                                        <button class="btn btn-primary details_button" data-toggle="modal" data-target="#invoice_details_modal" data-id="{{$invoice->id}}">
                                            Details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="modal fade" id="invoice_details_modal" tabindex="-1" role="dialog" aria-labelledby="add_customer_modal_label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="add_customer_modal_label">Invoice</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <div id="print_container">
                                    <div class="form-inline">
                                        <label for="invoice_by">Invoice Prepared By: </label>
                                        <strong id="invoice_by" style="padding-left: 10px"></strong>
                                    </div>
                                    <div class="form-inline">
                                        <label for="invoice_to">Invoice To: </label>
                                        <strong id="invoice_to" style="padding-left: 10px"></strong>
                                    </div>
                                    <br><br>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Unit Price</th>
                                            <th>Quanity</th>
                                            <th>Total Price</th>
                                        </tr>
                                        </thead>
                                        <tbody id="invoice_display"></tbody>
                                    </table>
                                    <div class="form-group">
                                        <label for="total_payable"><strong>Total Payable: </strong></label>
                                        <strong id="total_payable"></strong>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success" id="print_button">Print</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let rowCount = 0; 
    $(document).ready(function(){
        $('.details_button').click(function(){
            const id = $(this).attr('data-id');
            $.ajax({
                url: 'invoice/'+id,
                type: 'GET',
                data: {
                    "id": id
                },
                success:function(data) {
                    $('#invoice_by').html(data.invoice_by);
                    $('#invoice_to').html(data.invoice_to);

                    $('#invoice_display').html('');
                    
                    for (const index in data.sales) {
                        $("#invoice_display").append(
                            '<tr>' +
                            '<td id="product_name'+index+'">'+data.sales[index].product_name+'</td>' +
                            '<td id="price'+index+'">'+data.sales[index].price+'</td>' +
                            '<td id="quantity'+index+'">'+data.sales[index].quantity+'</td>' +
                            '<td id="total_price'+index+'">'+data.sales[index].total_price+'</td>' +
                            '</tr>'
                        )
                    }
                    
                    $('#total_payable').html(data.total_price);
                }
            })
        });

        $('#print_button').click(function(){
            $('#print_container').print();
        });
    });

        

</script>