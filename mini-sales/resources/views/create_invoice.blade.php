<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 form-group" style="width:60%; margin:0 auto;">
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
                    <div class="alert" style="color: red; text-align: center;" id="error"></div>
                    <label for="customer">Choose Customer:</label>
                    <select class="form-control" name="customer" id="customer" style="margin-right:15px">
                        <option value="">Select</option>
                        @foreach ($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                        @endforeach
                    </select>
                    <br>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_customer_modal">
                        Add Customer
                    </button>
                    <div class="modal fade" id="add_customer_modal" tabindex="-1" role="dialog" aria-labelledby="add_customer_modal_label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="add_customer_modal_label">Add Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <form id="add_form">
                                    @csrf
                                    <div class="form-group">
                                      <label for="name">Name</label>
                                      <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                    </div>
                                    <div class="form-group">
                                      <label for="phone_number">Phone Number</label>
                                      <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                  </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    <br><br>
                    <label for="product">Choose product:</label>
                    <select class="form-control" name="product" id="product" style="margin-right:15px">
                        <option value="">Select</option>
                        @foreach ($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="quantity">Quanity:</label>
                    <input class="form-control" type="number" name="quantity" id="quantity" min="1" style="margin-right:15px">
                    <br>
                    <button class="btn btn-secondary" id="add_product_button" onclick="invoiceDisplay({{$products}})" style="margin-right:10px">Add</button>
                    <input id="products" value="{{$products}}" hidden>
                </div>
            </div>
            <br>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <form action="save-invoice" method="POST">
                        @csrf
                        <div id="invoiceDisplay"></div>
                        <br>
                        <button type="submit" class="btn btn-primary" id="add_product_button">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let rowCount = 0;
    let total_amount = 0;
    let max_rowCount = 0;
    let copy_of_products;

    $(document).ready(function(){
        $('#add_form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/add-customer",
                data: $('#add_form').serialize(),
                success: function(response) {
                    console.log(response)
                    $('#add_customer_modal').modal('hide')
                    alert("Customer Saved")
                    location.reload();
                },
                error: function(error){
                    alert("Customer Not Saved");
                }
            });
        });
    });

    function invoiceDisplay(products){
        if(rowCount == 0){
            copy_of_products = products;
        }
        let customer_id = $('#customer').val();
        let product_id = $("#product").val();
        let quantity = $("#quantity").val();
        if(!customer_id) {
            $('#error_msg').remove();
            $("#error").append(
                '<h4 id="error_msg">Please select customer.</h4>'
            )
        }
        else if(!product_id) {
            $('#error_msg').remove();
            $("#error").append(
                '<h4 id="error_msg">Please select product.</h4>'
            )
        }
        else if(!quantity) {
            $('#error_msg').remove();
            $("#error").append(
                '<h4 id="error_msg">Please select quantity.</h4>'
            )
        }
        else{
            let product_index;
            for(index in copy_of_products){
                if (copy_of_products[index]['id'] == product_id){
                    product_index = index;
                    break;
                }
            }
            let stock = copy_of_products[product_index]['quantity'];
            if(stock<quantity) {
                $('#error_msg').remove();
                $("#error").append(
                    '<h4 id="error_msg">Stock available for this product is '+stock+'!.</h4>'
                )
            } else{
                rowCount ++;
                copy_of_products[product_index]['quantity'] = stock - quantity;
                $('#error_msg').remove();
                let name = products[product_index]['name'];
                let price = quantity * products[product_index]['sales_price'];
                total_amount = total_amount + price;
                
                if(max_rowCount<rowCount) max_rowCount = rowCount;

                if(rowCount == 1) {
                    $("#invoiceDisplay").append(
                        '<input type="number" name="customer_id" value="'+customer_id+'" hidden>'
                    )
                }
                $('#total').remove();
                $("#invoiceDisplay").append(
                    '<div class="form-inline" style="width:80%; margin:0 auto; padding-bottom: 5px;" id="'+rowCount+'">' +
                    '<input class="form-control" style="margin-right:10px" type="text" name="product_name'+rowCount+'" value="'+name+'" readonly>' +
                    '<input class="form-control" style="margin-right:10px" type="number" name="quantity'+rowCount+'" id="quantity'+rowCount+'" value="'+quantity+'" readonly>' +
                    '<input class="form-control" style="margin-right:10px" type="number" name="price'+rowCount+'" id="price'+rowCount+'" value="'+price+'" readonly>' +
                    '<input type="number" name="id'+rowCount+'" id="id'+rowCount+'" value="'+product_id+'" hidden>' +
                    '<input type="number" name="total_row" value="'+max_rowCount+'" hidden>' +
                    '<button class="btn btn-danger" style="width:5%; margin:0 auto;" type="button" onClick="deleteRow('+rowCount+')">X</button>' +
                    '<br><br>' +
                    '</div>' +
                    '<h5 id="total">Total = '+ total_amount+'</h5>'
                )
            }
        }
    }

    function deleteRow(id){
        rowCount --;
        let product_index;
        let product_id = $('#id' + id).val();
        for(index in copy_of_products){
            if (copy_of_products[index]['id'] == product_id){
                product_index = index;
                break;
            }
        }
        let stock = copy_of_products[product_index]['quantity'];
        let quantity = $('#quantity' + id).val();
        copy_of_products[product_index]['quantity'] = (stock + 1) + (quantity - 1);
        
        total_amount = total_amount - $('#price'+id+'').val();
        $('#total').remove();
        $("#invoiceDisplay").append(
            '<h5 id="total">Total = '+ total_amount+'</h5>'
        )
        $('#'+id).remove();
    }

</script>