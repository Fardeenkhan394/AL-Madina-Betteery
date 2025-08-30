@extends('admin_panel.layout.app')
@section('content')
    
<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title mt-2">
                    {{-- <h4>Bulk Set Prices</h4> --}}
                    <h5>Update Prices for Multiple Products</h5>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            <strong>Success!</strong> {{ session('success') }}.
                        </div>
                    @endif
                    
                    <form action="{{ route('products.bulkUpdatePrices') }}" method="POST" id="bulkPriceForm">
                        @csrf
                        <input type="hidden" name="product_ids" value="{{ $product_ids }}">
                        
                        {{-- @dd($products) --}}
                        @foreach($products as $product)
                        {{-- @dd($product->prices->toArray()) --}}
                        <div class="product-section mb-4 border rounded p-3">
                            <h5 class="text-dark mb-3">{{ $product->name }} (ID: {{ $product->id }})</h5>
                            
                            <div class="row gx-4">
                                <!-- Purchase Section -->
                                <div class="col-md-6">
                                    <h6 class="text-primary mb-2">Purchase Details</h6>
                                    <div class="border rounded p-3 bg-light h-100">
                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label class="form-label">Retail Price</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="products[{{ $product->id }}][purchase_retail_price]" 
                                                    value="{{ $product->latestPrice->purchase_retail_price }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">Tax (%)</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="products[{{ $product->id }}][purchase_tax_percent]" 
                                                    value="{{ $product->latestPrice->purchase_tax_percent }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">After Tax</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $product->latestPrice->purchase_tax_amount }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">Discount (%)</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="products[{{ $product->id }}][purchase_discount_percent]" 
                                                    value="{{ $product->latestPrice->purchase_discount_percent }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">Discount Amt</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $product->latestPrice->purchase_discount_amount }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">Net Amount</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $product->latestPrice->purchase_net_amount }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sale Section -->
                                <div class="col-md-6">
                                    <h6 class="text-success mb-2">Sale Details</h6>
                                    <div class="border rounded p-3 bg-light h-100">
                                        <div class="row">
                                            <div class="mb-3 col-4">
                                                <label class="form-label">Retail Price</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="products[{{ $product->id }}][sale_retail_price]" 
                                                    value="{{ $product->latestPrice->sale_retail_price }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">Tax (%)</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="products[{{ $product->id }}][sale_tax_percent]" 
                                                    value="{{ $product->latestPrice->sale_tax_percent }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">After Tax</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $product->latestPrice->sale_tax_amount }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">WHT (%)</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="products[{{ $product->id }}][sale_wht_percent]" 
                                                    value="{{ $product->latestPrice->sale_wht_percent ?? 0.5 }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">Discount (%)</label>
                                                <input type="number" step="0.01" class="form-control" 
                                                    name="products[{{ $product->id }}][sale_discount_percent]" 
                                                    value="{{ $product->latestPrice->sale_discount_percent }}">
                                            </div>
                                            <div class="mb-3 col-4">
                                                <label class="form-label">Net Amount</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ $product->latestPrice->sale_net_amount }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="modal-footer mt-4 border-0">
                            <button type="submit" class="btn btn-primary">Update All Prices</button>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(document).ready(function() {
    // Calculate values when inputs change
    $('.product-section').each(function() {
        const section = $(this);
        
        // Purchase calculation
        section.find('input[name*="purchase_retail_price"], input[name*="purchase_tax_percent"], input[name*="purchase_discount_percent"]').on('input', function() {
            calculatePurchaseValues(section);
        });
        
        // Sale calculation
        section.find('input[name*="sale_retail_price"], input[name*="sale_tax_percent"], input[name*="sale_wht_percent"], input[name*="sale_discount_percent"]').on('input', function() {
            calculateSaleValues(section);
        });
    });
    
    function calculatePurchaseValues(section) {
        const retailPrice = parseFloat(section.find('input[name*="purchase_retail_price"]').val()) || 0;
        const taxPercent = parseFloat(section.find('input[name*="purchase_tax_percent"]').val()) || 0;
        const discountPercent = parseFloat(section.find('input[name*="purchase_discount_percent"]').val()) || 0;
        
        const taxAmount = (retailPrice * taxPercent / 100).toFixed(2);
        const discountAmount = (retailPrice * discountPercent / 100).toFixed(2);
        const netAmount = (retailPrice + parseFloat(taxAmount) - parseFloat(discountAmount)).toFixed(2);
        
        section.find('input[value*="purchase_tax_amount"]').val(taxAmount);
        section.find('input[value*="purchase_discount_amount"]').val(discountAmount);
        section.find('input[value*="purchase_net_amount"]').val(netAmount);
    }
    
    function calculateSaleValues(section) {
        const retailPrice = parseFloat(section.find('input[name*="sale_retail_price"]').val()) || 0;
        const taxPercent = parseFloat(section.find('input[name*="sale_tax_percent"]').val()) || 0;
        const whtPercent = parseFloat(section.find('input[name*="sale_wht_percent"]').val()) || 0.5;
        const discountPercent = parseFloat(section.find('input[name*="sale_discount_percent"]').val()) || 0;
        
        const taxAmount = (retailPrice * taxPercent / 100).toFixed(2);
        const whtAmount = (taxAmount * whtPercent / 100).toFixed(2);
        const discountAmount = (retailPrice * discountPercent / 100).toFixed(2);
        const netAmount = (retailPrice + parseFloat(taxAmount) + parseFloat(whtAmount) - parseFloat(discountAmount)).toFixed(2);
        
        section.find('input[value*="sale_tax_amount"]').val(taxAmount);
        section.find('input[value*="sale_discount_amount"]').val(discountAmount);
        section.find('input[value*="sale_net_amount"]').val(netAmount);
    }
    
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
    @endif
    
    @if ($errors->any())
        let errorMessages = `{!! implode('<br>', $errors->all()) !!}`;
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: errorMessages,
            timer: 3000,
            showConfirmButton: false
        });
    @endif
});
</script>
@endsection