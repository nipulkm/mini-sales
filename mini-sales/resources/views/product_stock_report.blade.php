<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Stock Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table text-center" id="print_container">
                        <thead>
                          <tr>
                            <th>Product Name</th>
                            <th>Quantity sold</th>
                            <th>Current Stock</th>
                            <th>Purchase Price</th>
                            <th>Sales Price</th>
                            <th>Total Current Stock Sales Price</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($product_details as $product)
                                <tr>
                                    <td>{{$product['name']}}</td>
                                    <td>{{$product['quantity_sold']}}</td>
                                    <td>{{$product['stock']}}</td>
                                    <td>{{$product['purchase_price']}}</td>
                                    <td>{{$product['sales_price']}}</td>
                                    <td>{{$product['stock_sales_price']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-group text-center">
                        <button class="btn btn-success" id="print_button">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    $(document).ready(function(){
        $('#print_button').click(function(){
            $('#print_container').print();
        });
    });
</script>