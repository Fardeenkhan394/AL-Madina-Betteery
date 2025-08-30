@extends('admin_panel.layout.app')

@section('content')
     <div class="main-content">
            <div class="main-content-inner">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 ">
                                  <div class="page-header">
                <div class="page-title">
                    <h4>Edit Product</h4>
                    <h6>Manage Product Details</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if (session()->has('success'))
                    <div class="alert alert-success">
                        <strong>Success!</strong> {{ session('success') }}.
                    </div>
                    @endif
                    <form action="{{ route('products.updatePrice', $product->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                        
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Item Name</label>
                                    <input type="text" class="form-control" name="name" required placeholder="Product Name" value="{{ $product->name }}" readonly> 
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description" required placeholder="Description" value="{{ $product->name }}" readonly>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" class="form-control" name="price" required placeholder="Product New Price"> 
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Tax Percent</label>
                                    <input type="number" class="form-control" name="tax_percent" required placeholder="New Tax Percent">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Discount Percent</label>
                                    <input type="number" class="form-control" name="discount_percent" required placeholder="New Discount Percent">
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
                        </div>
                     
                    </div>
                    </div>
                    </div>
                    </div>
@endsection