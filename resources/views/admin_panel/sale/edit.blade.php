@extends('admin_panel.layout.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-container {
            font-size: 0.75rem;
            max-width: 1200px;
        }

        .header-text {
            font-size: 1rem;
            text-shadow: 1px 1px 1px #ccc;
        }

        .form-control,
        .form-select,
        .btn {
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            height: auto;
        }

        .form-row {
            align-items: center;
            margin-bottom: 0.3rem;
        }

        .form-row label {
            width: 100px;
            white-space: nowrap;
        }

        .table {
            --bs-table-padding-y: 0.2rem;
            --bs-table-padding-x: 0.3rem;
            font-size: 0.75rem;
        }

        .table th,
        .table td {
            white-space: nowrap;
        }

        .table thead th {
            text-align: center;
        }

        .table-responsive {
            max-height: 250px;
            overflow-y: auto;
        }

        .footer-buttons .btn {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
        }
    </style>
    <div class="container-fluid py-4">
        <div class="main-container bg-white border shadow-sm mx-auto p-2">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('sale.update', $sale->id) }}" method="POST">
                @csrf

                <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                    <small class="text-secondary">Entry Date_Time: 01-07-24 &nbsp;&nbsp; 06:48 PM</small>
                    <div class="d-flex align-items-center">
                        <img src="https://i.imgur.com/L7p41j4.png" alt="Logo" height="25" class="me-2">
                        <h5 class="header-text text-secondary fw-bold mb-0">Sales</h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <small class="text-secondary me-3">Date: &nbsp;&nbsp; 01-07-24</small>
                        <button class="btn btn-sm btn-light border">Posted</button>
                    </div>
                </div>

                <div class="d-flex border-bottom">
                    <div class="p-3 border-end" style="min-width: 350px;">
                        <div class="d-flex align-items-center mb-2">
                            <label class="form-label fw-bold me-2">Invoice No.</label>
                            <input type="text" class="form-control me-2" name="Invoice_no" style="width: 100px;"
                                {{--  value="{{ $nextInvoiceNumber }}" readonly>  --}}

                            <label class="form-label fw-bold me-2">M. Inv#</label>
                            <input type="text" class="form-control" name="Invoice_main"
                                placeholder="Enter manual invoice">
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <label class="form-label fw-bold me-2">Customer:</label>
                            <select class="form-select" name="customer" id="customerSelect">
                                <option>Customer select</option>
                                @foreach ($customers as $customer)
                       <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
    {{ $customer->customer_id . ' ' . $customer->customer_name }}
</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <label class="form-label fw-bold me-2">Sub Customer:</label>
                       <select id="customerType" name="customerType" class="form-select me-2" style="width: 120px;">
    <option value="">Sub Customer</option>
    <option value="{{ $sale->sub_customer }}" selected>{{ $sale->sub_customer }}</option>
</select>
                         <input type="text" id="filerType" name="filerType" class="form-control" placeholder="Filer Type" value="{{ $sale->filer_type }}">

                        </div>
                        <div class="d-flex mb-2">
                            <label class="form-label fw-bold me-2">Address</label>
                         <textarea class="form-control" id="address" name="address" rows="2">{{ $sale->address }}</textarea>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <label class="form-label fw-bold me-2">Tel#</label>
                          <input type="text" class="form-control" id="tel" name="tel" value="{{ $sale->tel }}">
                        </div>
                        <div class="d-flex mb-2">
                            <label class="form-label fw-bold me-2">Remarks:</label>
                           <textarea class="form-control" id="remarks" name="remarks" rows="2">{{ $sale->remarks }}</textarea>

                        </div>
                        <div class="text-end mt-3">
                            <button id="clearCustomerData" class="btn btn-sm btn-secondary">Delete</button>
                        </div>

                    </div>

                    <div class="flex-grow-1 p-3" style="max-width: 100%; overflow-x: auto;">
                        <div class="table-responsive" style="max-width: 100%; overflow-x: auto;">
                            <table class="table table-bordered mb-0" style="min-width: 1200px;">
                                <thead>
                                    <tr>
                                        <th>Warehouse</th>
                                        <th>product </th>
                                        <th>stock</th>
                                        <th>Price Level</th>
                                        <th>Sales Price</th>
                                        <th>Sales Qty</th>
                                        <th>Retail Price</th>
                                        <th>Dis. (%)</th>
                                        <th>Dis. Amt.</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="salesTableBody">
                                @foreach ($sale->items as $item)
<tr>
    <td>
        <select class="form-select warehouse form-control" name="warehouse_name[]">
            <option value="">Select</option>
            @foreach ($warehouses as $wh)
                <option value="{{ $wh->id }}" {{ $item->warehouse_id == $wh->id ? 'selected' : '' }}>
                    {{ $wh->warehouse_name }}
                </option>
            @endforeach
        </select>
    </td>
    <td>
        <select class="form-select product form-control" name="product_name[]">
            <option value="{{ $item->product_id }}" selected>
                {{ $item->product_id}}
            </option>
        </select>
    </td>
    <td><input type="text" class="form-control stock text-danger text-center" name="stock[]" value="{{ $item->stock }}" readonly></td>
    <td><input type="text" class="form-control text-end price" name="price[]" value="{{ $item->price_level }}" readonly></td>
    <td><input type="text" class="form-control text-end sales-price" name="sales-price[]" value="{{ $item->sales_price }}"></td>
    <td><input type="text" class="form-control text-end sales-qty" name="sales-qty[]" value="{{ $item->sales_qty }}"></td>
    <td><input type="text" class="form-control text-end retail-price" name="retail-price[]" value="{{ $item->retail_price }}"></td>
    <td><input type="text" class="form-control text-end discount-percent" name="discount-percent[]" value="{{ $item->discount_percent }}"></td>
    <td><input type="text" class="form-control text-end discount-amount" name="discount-amount[]" value="{{ $item->discount_amount }}"></td>
    <td><input type="text" class="form-control text-end sales-amount" name="sales-amount[]" value="{{ $item->amount }}" readonly></td>
</tr>
@endforeach
 <tr>
                                    <td> <select class="form-select warehouse form-control" name="warehouse_name[]">
                                            <option value="">Select</option>
                                            @foreach ($warehouses as $wh)
                                                <option value="{{ $wh->id }}">{{ $wh->warehouse_name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>

                                        <select class="form-select product form-control" name="product_name[]">
                                           
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control stock text-danger text-center" name="stock[]" readonly ></td>
                                    <td><input type="text" class="form-control text-end price" name="price[]" readonly></td>
                                 <td><input type="text" class="form-control text-end sales-price" name="sales-price[]" value="0"></td>
<td><input type="text" class="form-control text-end sales-qty" value="0" name="sales-qty[]"></td>
<td><input type="text" class="form-control text-end retail-price" name="retail-price[]" value="0"></td>
<td><input type="text" class="form-control text-end discount-percent" name="discount-percent[]" value="0"></td>
<td><input type="text" class="form-control text-end discount-amount" name="discount-amount[]" value="0"></td>
<td><input type="text" class="form-control text-end sales-amount" name="sales-amount[]" value="0" readonly></td>


                                </tr>

                                    {{--  <tr>
    <td colspan="9" class="text-end"><b>Total:</b></td>
    <td><b id="totalAmount">0.00</b></td>
</tr>  --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between p-3 border-bottom">
                    <div style="min-width: 350px;">
                        <p class="mb-1">Wednesday, 13 August, 2025</p>
                        <div class="d-flex align-items-center mb-1">
                            <label class="form-label fw-bold me-2">Sub Total-2:</label>
                            <input type="text"
                                class="form-control text-end fw-bold text-primary bg-info-subtle border-primary"
                                value="0">
                        </div>
                        <div class="d-flex align-items-center mb-1">
                            <label class="form-label fw-bold me-2">Advance Tax:</label>
                            <input type="text" class="form-control text-end me-2" style="width: 70px;"
                                value="0.00">
                            <input type="text" class="form-control text-end" style="width: 70px;" value="0.00">
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="d-flex justify-content-end align-items-center mb-1">
                            <label class="form-label me-2">Sub Total:</label>
                            <input type="text" class="form-control text-end me-2" style="width: 70px;" 
                                name="subTotal1" id="subTotal1" value="{{ $sale->sub_total1 }}">
                            <input type="text" class="form-control text-end me-2" style="width: 70px;" 
                                name="subTotal2" id="subTotal2" value="{{ $sale->sub_total2 }}">
                            <input type="text" class="form-control text-end fw-bold text-primary"
                                style="width: 150px;" value="0">
                        </div>
                        <div class="d-flex justify-content-end align-items-center mb-1">
                            <label class="form-label me-2">Discount:</label>
                            <input type="text" class="form-control text-end me-2" style="width: 120px;"
                                value="{{ $sale->discount_percent }}" name="discountPercent" id="discountPercent">
                            <input type="text" class="form-control text-end" style="width: 150px;" value="0">
                        </div>
                        <div class="d-flex justify-content-end align-items-center mb-1">
                            <label class="form-label me-2">Discount Rs:</label>
                            <input type="text" class="form-control text-end" style="width: 150px;" value="{{ $sale->discount_amount }}"
                                name="discountAmount" id="discountAmount">
                        </div>
                        <div class="d-flex justify-content-end align-items-center mb-1">
                            <label class="form-label text-danger me-2">Previous Balance:</label>
                            <input type="text" class="form-control text-end text-danger" style="width: 150px;"
                                value="{{ $sale->previous_balance }}" id="previousBalance" name="previousBalance">
                        </div>
                        <div class="d-flex justify-content-end align-items-center mb-1">
                            <label class="form-label fw-bold text-primary me-2">Total Balance:</label>
                            <input type="text"
                                class="form-control text-end fw-bold text-primary bg-info-subtle border-primary"
                                style="width: 150px;"  value="{{ $sale->total_balance }}" id="totalBalance" name="totalBalance">
                        </div>
                        <div class="d-flex justify-content-end align-items-center mb-1">
                            <label class="form-label me-2">Receipt Voucher:</label>
                            <input type="text" class="form-control me-2" style="width: 250px;" value="">
                            <input type="text" class="form-control text-end me-2" style="width: 90px;"
                                name="receipt1"  id="receipt1" value="{{ $sale->receipt1 }}">
                            <input type="text" class="form-control text-end" style="width: 70px;"  value="{{ $sale->receipt2 }}"
                                name="receipt2" id="receipt2">
                        </div>
                        <div class="d-flex justify-content-end align-items-center mb-1">
                            <label class="form-label me-2">Final Balance:</label>
                            <input type="text" class="form-control text-end me-2" style="width: 150px;"
                               value="{{ $sale->final_balance1 }}" name="finalBalance1" id="finalBalance1">
                            <input type="text" class="form-control text-end" style="width: 150px;"value="{{ $sale->final_balance2 }}"
                                name="finalBalance2" id="finalBalance2">
                        </div>
                    </div>
                </div>

                <div class="footer-buttons d-flex justify-content-center p-3">
                    <button class="btn btn-sm btn-light border me-1">First</button>
                    <button class="btn btn-sm btn-light border me-1">Previous</button>
                    <button class="btn btn-sm btn-light border me-1">Next</button>
                    <button class="btn btn-sm btn-light border me-1">Last</button>
                    <button class="btn btn-sm btn-primary me-1">Add</button>
                    <button class="btn btn-sm btn-primary me-1">Edit</button>
                    <button class="btn btn-sm btn-warning me-1">Revert</button>
                    <button type="submit" class="btn btn-sm btn-success me-1 ">Save</button>
                    <button class="btn btn-sm btn-danger me-1">Delete</button>
                    <button class="btn btn-sm btn-info me-1">Receipt</button>
                    <button class="btn btn-sm btn-secondary me-1">Print</button>
                    <button class="btn btn-sm btn-secondary me-1">Print-2</button>
                    <button class="btn btn-sm btn-secondary me-1">QC Print</button>
                    <button class="btn btn-sm btn-dark">Exit</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // When warehouse changes → load products
        $(document).on('change', '.warehouse', function() {
            var warehouseId = $(this).val();
            var $productSelect = $(this).closest('tr').find('.product');
            if (warehouseId) {
                $.ajax({
                    url: '{{ url('get-products-by-warehouse') }}/' + warehouseId,
                    type: 'GET',
                    success: function(data) {
                        $productSelect.empty().append('<option value="">Select Product</option>');
                        $.each(data, function(key, value) {
                            $productSelect.append('<option value="' + value.item_name + '">' +
                                value.item_name + '</option>');
                        });
                    }
                });
            } else {
                $productSelect.empty().append('<option value="">Select Product</option>');
            }
        });

        // When product changes → load stock
        // When product changes → load stock + price
        $(document).on('change', '.product', function() {
            var productName = $(this).find(':selected').text();
            var warehouseId = $(this).closest('tr').find('.warehouse').val();
            var $row = $(this).closest('tr'); // pura row select

            var $stockInput = $row.find('.stock');
            var $priceInput = $row.find('.price'); // price input ka reference

            if (warehouseId && productName) {
                $.ajax({
                    url: '{{ url('get-stock') }}/' + warehouseId + '/' + productName,
                    type: 'GET',
                    success: function(data) {
                        $stockInput.val(data.stock); // stock set karega
                        $priceInput.val(data.price); // price set karega
                    }
                });
            } else {
                $stockInput.val('');
                $priceInput.val('');
            }
        });

        {{--  totalcount  --}}

        $(document).on('input', '.sales-price, .sales-qty, .discount-percent, .discount-amount', function() {
            let $row = $(this).closest('tr');

            // Values
            let salesPrice = parseFloat($row.find('.sales-price').val()) || 0;
            let salesQty = parseFloat($row.find('.sales-qty').val()) || 0;
            let discountPercent = parseFloat($row.find('.discount-percent').val()) || 0;
            let discountAmount = parseFloat($row.find('.discount-amount').val()) || 0;

            // Calculate Amount
            let grossAmount = salesPrice * salesQty;

            // If discount in %
            if (discountPercent > 0) {
                discountAmount = (grossAmount * discountPercent) / 100;
                $row.find('.discount-amount').val(discountAmount.toFixed(2));
            }

            let netAmount = grossAmount - discountAmount;
            $row.find('.sales-amount').val(netAmount.toFixed(2));

            // Update Total Sum
            updateTotalAmount();
        });

        function updateTotalAmount() {
            let total = 0;
            $('.sales-amount').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('#totalAmount').text(total.toFixed(2));
        }


        {{--  selct customer  --}}
        {{--  $(document).ready(function () {  --}}
        $(document).on('change', '#customerSelect', function() {
            let id = $(this).val();
            if (id) {
                $.get('{{ url('/get-customer') }}/' + id, function(data) {

                    // Filer type
                    $('#filerType').val(data.filer_type);

                    // Customer type (Sub Customer select)
                    let $customerType = $('#customerType');
                    $customerType.empty(); // pehle saare options clear karo
                    $customerType.append('<option value="">Sub Customer</option>');
                    if (data.customer_type) {
                        $customerType.append('<option value="' + data.customer_type + '" selected>' + data
                            .customer_type + '</option>');
                    }

                    // Baaki fields
                    $('#address').val(data.address);
                    $('#tel').val(data.mobile);
                    $('#remarks').val(data.remarks);
                });
            }
        });

        // Delete button click
        $(document).on('click', '#clearCustomerData', function() {
            $('#customerSelect').val('');
            $('#filerType').val('');
            $('#customerType').empty().append('<option value="">Sub Customer</option>');
            $('#address').val('');
            $('#tel').val('');
            $('#remarks').val('');
        });

        {{--  adding new row miltiple  --}}
        $(document).ready(function() {
            // Function to add a new empty row
            function addNewRow() {
                let newRow = `<tr>
            <td>
                <select class="form-select warehouse form-control" name="warehouse_name[]">
                    <option value="">Select</option>
                    @foreach ($warehouses as $wh)
                        <option value="{{ $wh->id }}">{{ $wh->warehouse_name }}</option>
                    @endforeach
                </select>
            </td>
            <td><select class="form-select product form-control" name="product_name[]"></select></td>
            <td><input type="text" class="form-control stock text-danger text-center" readonly  name="stock[]" ></td>
            <td><input type="text" class="form-control text-end price"  name="stock[]" ></td>
            <td><input type="text" class="form-control text-end sales-price" value="0"  name="sales-price[]"></td>
            <td><input type="text" class="form-control text-end sales-qty" value="0" name="sales-qty[]"></td>
            <td><input type="text" class="form-control text-end retail-price" value="0" name="retail-price[]"></td>
            <td><input type="text" class="form-control text-end discount-percent" value="0" name="discount-percent[]" ></td>
            <td><input type="text" class="form-control text-end discount-amount" value="0" name="discount-amount[]"> </td>
            <td><input type="text" class="form-control text-end sales-amount" value="0" name="sales-amount[]" readonly></td>
        </tr>`;
                $('#salesTableBody').append(newRow);
            }

            // Jab qty fill ho jaye to nayi row aa jaye
            $('#salesTableBody').on('input', '.sales-amount', function() {
                let row = $(this).closest('tr');
                let qty = $(this).val();

                if (qty !== "" && row.is(':last-child')) {
                    addNewRow();
                }
            });
        });

        {{--  total all rows sub discount  --}}
    </script>
    <script>
        function calculateTotals() {
            let subTotal1 = 0; // sum of grossAmount
            let subTotal2 = 0; // sum of netAmount

            $('#salesTableBody tr').each(function() {
                let salesPrice = parseFloat($(this).find('.sales-price').val()) || 0;
                let salesQty = parseFloat($(this).find('.sales-qty').val()) || 0;
                let discountAmount = parseFloat($(this).find('.discount-amount').val()) || 0;

                let grossAmount = salesPrice * salesQty;
                let netAmount = grossAmount - discountAmount;

                subTotal1 += grossAmount;
                subTotal2 += netAmount;
            });

            // Update subtotals
            $('#subTotal1').val(subTotal1.toFixed(2));
            $('#subTotal2').val(subTotal2.toFixed(2));

            // Discount %
            let discountPercent = parseFloat($('#discountPercent').val() || 0);
            let discountValue = (subTotal1 * discountPercent) / 100;
            $('#discountAmount').val(discountValue.toFixed(2));

            // Previous Balance
            let prevBalance = parseFloat($('#previousBalance').val() || 0);

            // Total Balance
            let totalBalance = subTotal2 - discountValue + prevBalance;
            $('#totalBalance').val(totalBalance.toFixed(2));

            // Receipt
            let receipt1 = parseFloat($('#receipt1').val() || 0);
            let receipt2 = parseFloat($('#receipt2').val() || 0);

            let finalBalance1 = totalBalance - receipt1;
            let finalBalance2 = totalBalance - receipt2;

            $('#finalBalance1').val(finalBalance1.toFixed(2));
            $('#finalBalance2').val(finalBalance2.toFixed(2));
        }

        // Event listener har input change pe call
        $(document).on('input',
            '.sales-price, .sales-qty, .discount-percent, .discount-amount, #previousBalance, #discountPercent, #receipt1, #receipt2',
            function() {
                calculateTotals();
            });
    </script>
@endsection
