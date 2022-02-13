<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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
                    <form action="save-product" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" placeholder="Enter name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <input type="text" class="form-control" placeholder="Enter description" name="description" required>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" class="form-control" placeholder="Enter quantity" name="quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="purchase_price">Purchase Price:</label>
                            <input type="number" class="form-control" placeholder="Enter purchase price" name="purchase_price" required>
                        </div>
                        <div class="form-group">
                            <label for="sales_price">Sales Price:</label>
                            <input type="number" class="form-control" placeholder="Enter sales price" name="sales_price" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                      </form> 
                </div>
            </div>
        </div>
    </div>
    @if (!$products->isEmpty())
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Purchase Price</th>
                                <th>Sales Price</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->description}}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td>{{$product->purchase_price}}</td>
                                        <td>{{$product->sales_price}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
