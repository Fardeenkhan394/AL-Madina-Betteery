@extends('admin_panel.layout.app')
@section('content')

<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <div>
                <h5 class="mb-0">Product List</h5>
                <small class="text-muted">Manage Products</small>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('products.create') }}">Add Product</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="default-datatable" class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Base Price (PKR)</th>
                            <th>Discount (%)</th>
                            <th>Discount (PKR)</th>
                            <th>Tax (%)</th>
                            <th>Tax (PKR)</th>
                            <th>WHT (%)</th>
                            <th>WHT (PKR)</th>
                            <th>Net Amount (PKR)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                            @php
                                $price = $product->latestPrice->price ?? 0;
                                $discountPercent = $product->latestPrice->discount_percent ?? 0;
                                $taxPercent = $product->latestPrice->tax_percent ?? 0;
                                $whtPercent = $product->latestPrice->wht_percent ?? 0;

                                $discountPKR = ($price * $discountPercent) / 100;
                                $taxPKR = ($price * $taxPercent) / 100;
                                $whtPKR = ($price * $whtPercent) / 100;

                                $netAmount = ($price - $discountPKR) + $taxPKR - $whtPKR;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ number_format($price, 2) }}</td>
                                <td>{{ $discountPercent }}%</td>
                                <td>Rs. {{ number_format($discountPKR, 2) }}</td>
                                <td>{{ $taxPercent }}%</td>
                                <td>Rs. {{ number_format($taxPKR, 2) }}</td>
                                <td>{{ $whtPercent }}%</td>
                                <td>Rs. {{ number_format($whtPKR, 2) }}</td>
                                <td><strong>Rs. {{ number_format($netAmount, 2) }}</strong></td>
                                <td>
                                    <a class="btn btn-sm btn-primary" href="{{ route('products.edit', $product->id) }}">Set New Price</a>
                                    <button class="btn btn-sm btn-secondary view-history-btn" data-product-id="{{ $product->id }}">
                                        Price History
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Price History Modal -->
<div class="modal fade" id="priceHistoryModal" tabindex="-1" role="dialog" aria-labelledby="priceHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Price History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="price-history-body">
                <p>Loading...</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.view-history-btn').click(function () {
            const productId = $(this).data('product-id');
            $('#price-history-body').html('<p>Loading...</p>');

            $.ajax({
                url: '/products/' + productId + '/prices',
                type: 'GET',
                success: function (html) {
                    $('#price-history-body').html(html);
                    $('#priceHistoryModal').modal('show');
                },
                error: function () {
                    $('#price-history-body').html('<p class="text-danger">Failed to load data.</p>');
                }
            });
        });

        $('#default-datatable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 100],
            order: [[0, 'desc']],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries"
            }
        });
    });
</script>
@endsection
