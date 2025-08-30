{{-- Item Row Autocomplete + Add/Remove --}}
<!-- Make sure jQuery and Bootstrap Typeahead are included -->
@extends('admin_panel.layout.app')
<style>
    .searchResults {
        position: absolute;
        z-index: 9999;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background: #fff;
        /* border: 1px solid #ddd; */
    }

    .search-result-item.active {
        background: #007bff;
        color: white;
    }

    th {
        font-weight: 500 !important;
    }
</style>
@section('content')
    <div class="main-content bg-white">
        <div class="main-content-inner">
            <div class="">
                <div class="row">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
                        rel="stylesheet">

                    <style>
                        .table-scroll tbody {
                            display: block;
                            max-height: calc(60px * 5);
                            /* Assuming each row is ~40px tall */
                            overflow-y: auto;
                        }

                        .table-scroll thead,
                        .table-scroll tbody tr {
                            display: table;
                            width: 100%;
                            table-layout: fixed;
                        }

                        /* Optional: Hide scrollbar width impact */
                        .table-scroll thead {
                            width: calc(100% - 1em);
                        }

                        .table-scroll .icon-col {
                            width: 51px;
                            /* Ya jitni chhoti chahiye */
                            min-width: 51px;
                            max-width: 40px;
                        }

                        .table-scroll {
                            max-height: none !important;
                            overflow-y: visible !important;
                        }


                        .disabled-row input {
                            background-color: #f8f9fa;
                            pointer-events: none;
                        }
                    </style>

                    <body>
                        <!-- page-wrapper start -->

                        <div class="body-wrapper">
                            <div class="bodywrapper__inner">
                                <div
                                    class="d-flex justify-content-between align-items-center mb-3 flex-nowrap overflow-auto">
                                    <!-- Title on the left -->
                                    <div class="flex-grow-1 ">
                                        <h6 class="page-title ml-4">INWARDS GATE PASSES</h6>
                                    </div>

                                    <!-- Buttons on the right -->
                                    <div class="d-flex gap-4 justify-content-end flex-wrap">
                                        {{-- <button type="button" class="btn btn-outline-primary " style="margin-right: 5px"
                                            data-bs-toggle="modal" data-bs-target="#supplierModal">
                                            <i class="la la-truck-loading"></i> Add New Vendor
                                        </button>

                                        <button type="button" class="btn btn-outline-success " style="margin-right: 5px"
                                            data-bs-toggle="modal" data-bs-target="#transportModal">
                                            <i class="la la-truck"></i> Add New Transport
                                        </button>

                                        <button type="button" class="btn btn-outline-warning text-dark "
                                            style="margin-right: 5px" data-bs-toggle="modal"
                                            data-bs-target="#warehouseModal">
                                            <i class="la la-warehouse"></i> Add New Warehouse
                                        </button>

                                        <a href="#" class="btn btn-outline-info " style="margin-right: 5px">
                                            <i class="la la-plus"></i> Add Product
                                        </a> --}}

                                        {{-- <button type="button" class="btn btn-outline-danger " id="cancelBtn">
                                        Cancel
                                    </button> --}}
                                        <a href="{{ route('Purchase.home') }}" class="btn btn-danger mr-4">Back </a>
                                    </div>



                                </div>



                                <div class="row gy-3 ">
                                    <div class="col-lg-12 col-md-12 mb-30 m-auto">
                                        <div class="card">
                                            <div class="card-body  ml-2">
                                                {{-- <form action="{{ route('store-Purchase') }}" method="POST"> --}}
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                @if (session('success'))
                                                    <div class="alert alert-success alert-dismissible fade show"
                                                        role="alert">
                                                        <strong>Success!</strong> {{ session('success') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                <form action="{{ route('store.Purchase') }}" method="POST">
                                                    @csrf

                                                    <!-- Header Fields -->
                                                    <table class="table table-bordered table-sm text-center align-middle">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Current Date</th>
                                                                <th>DC Date</th>
                                                                <th>Type</th>
                                                                <th>Vendor</th>
                                                                <th cla>DC #</th>
                                                                <th>Warehouse</th>
                                                                <th>Bilty No</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input name="current_date" value="{{ date('Y-m-d') }}"
                                                                        type="date" class="form-control form-control-sm" required>
                                                                </td>
                                                                <td><input name="dc_date" value="{{ date('Y-m-d') }}"
                                                                        type="date" class="form-control form-control-sm" required>
                                                                </td>
                                                                <td>
                                                                    <select name="vendor_type"
                                                                        class="form-control form-control-sm" >
                                                                        {{-- <option disabled selected>Select Type</option> --}}
                                                                        <option selected>Vendor</option>
                                                                        <option >Customer</option>
                                                                        <option >Walkin Customer</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="vendor_id"
                                                                        class="form-control form-control-sm" style="width:105px;" required>
                                                                        <option disabled selected>Select</option>
                                                                        @foreach ($Vendor as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td><input name="dc" type="text"
                                                                        class="form-control form-control-sm" style="width:90px;" required></td>
                                                                <td>
                                                                    <select name="warehouse_id"
                                                                        class="form-control form-control-sm" required>
                                                                        <option disabled selected>Select</option>
                                                                        @foreach ($Warehouse as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->warehouse_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input name="bilty_no" type="text"
                                                                    class="form-control form-control-sm" style="width:90px;" required>
                                                                </td>
                                                                <td><input name="remarks" type="text"
                                                                        class="form-control form-control-sm"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- Product Table -->
                                                    <table
                                                        class="table table-bordered table-sm text-center align-middle mt-2">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Brand</th>
                                                                <th>Price</th>
                                                                <th>Disc</th>
                                                                <th>Qty</th>
                                                                <th>Total</th>
                                                                <th>X</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="purchaseItems">
                                                            <tr>
                                                                <td>
                                                                    <input type="hidden" name="product_id[]"
                                                                        class="product_id">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm productSearch"
                                                                        placeholder="Search product..." autocomplete="off">
                                                                    <ul class="searchResults list-group mt-1"></ul>
                                                                </td>
                                                                <td class="uom border"><input type="text" name="brand[]"
                                                                        class="form-control form-control-sm" readonly></td>
                                                                <td><input type="number" step="0.01" name="price[]"
                                                                        class="form-control form-control-sm price"></td>
                                                                <td><input type="number" step="0.01" name="item_disc[]"
                                                                        class="form-control form-control-sm item_disc"></td>
                                                                <td><input type="number" name="qty[]"
                                                                        class="form-control form-control-sm quantity"
                                                                        value="1" min="1"></td>
                                                                <td><input type="text" name="total[]"
                                                                        class="form-control form-control-sm row-total"
                                                                        readonly></td>
                                                                <td><button type="button"
                                                                        class="btn btn-sm btn-danger remove-row">X</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <!-- Totals -->
                                                    <table class="table table-bordered table-sm text-center mt-2">
                                                        <tr>
                                                            <th>Subtotal</th>
                                                            <td><input type="text" id="subtotal" name="subtotal"
                                                                    class="form-control form-control-sm" value="0"
                                                                    readonly></td>
                                                            <th>Discount</th>
                                                            <td><input type="number" step="0.01" id="overallDiscount" name="discount"
                                                                    class="form-control form-control-sm" value="0">
                                                            </td>
                                                            <th>WHT</th>
                                                            <td><input type="number" step="0.01" id="extraCost" name="wht"
                                                                    class="form-control form-control-sm" value="0">
                                                            </td>
                                                            <th>Net</th>
                                                            <td><input type="text" id="netAmount" name="net_amount"
                                                                    class="form-control form-control-sm fw-bold"
                                                                    value="0" readonly></td>
                                                        </tr>
                                                    </table>

                                                    <button type="submit" class="btn btn-primary btn-sm w-100">Submit
                                                        Purchase</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- bodywrapper__inner end -->
                        </div><!-- body-wrapper end -->
                </div>

                <!-- Warehouse Modal -->
                <div class="modal fade" id="warehouseModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Warehouse</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>

                            <form action="" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Branch</label>
                                        <select name="branch_id" class="form-control select2">
                                            <option disabled selected>Select Branch</option>
                                            <option value="0">Main Super Admin</option>
                                            {{-- @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Transport Modal -->
                <div class="modal fade" id="transportModal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Transport</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>

                            <form action="" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input type="text" name="company_name" class="form-control"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input type="number" name="mobile" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Veondor Modal -->
                <div class="modal fade" id="supplierModal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Supplier</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="las la-times"></i>
                                </button>
                            </div>

                            <form action="" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control"
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">E-Mail</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Mobile
                                                    <i class="fa fa-info-circle text--primary"
                                                        title="Type the mobile number including the country code. Otherwise, SMS won't send to that number."></i>
                                                </label>
                                                <input type="number" name="mobile" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Company</label>
                                                <input type="text" name="company_name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" name="address" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn--primary w-100 h-45">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Success & Error Messages --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: @json(session('success')),
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif


    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: {!! json_encode(implode('<br>', $errors->all())) !!},
                confirmButtonColor: '#d33',
            });
        </script>
    @endif

    {{-- Cancel Button Confirmation --}}
    <script>
        // Prevent Enter key from submitting form in product search
        $(document).on('keydown', '.productSearch', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // stops form submission
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const cancelBtn = document.getElementById('cancelBtn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This will cancel your changes!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, go back!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '';
                        }
                    });
                });
            }
        });
    </script>

    {{-- Item Row Autocomplete + Add/Remove --}}
    <!-- Make sure jQuery and Bootstrap Typeahead are included -->

    <script>
        $(document).ready(function() {

            // ---------- Helpers ----------
            function num(n) {
                return isNaN(parseFloat(n)) ? 0 : parseFloat(n);
            }

            function recalcRow($row) {
                const qty = num($row.find('.quantity').val());
                const price = num($row.find('.price').val());
                const disc = num($row.find('.item_disc').val()); // absolute PKR per item
                let total = (qty * price) - disc;
                if (total < 0) total = 0;
                $row.find('.row-total').val(total.toFixed(2));
            }

            function recalcSummary() {
                let sub = 0;
                $('#purchaseItems .row-total').each(function() {
                    sub += num($(this).val());
                });
                $('#subtotal').val(sub.toFixed(2));

                const oDisc = num($('#overallDiscount').val());
                const xCost = num($('#extraCost').val());
                const net = (sub - oDisc + xCost);
                $('#netAmount').val(net.toFixed(2));
            }

            function appendBlankRow() {
                const newRow = `
      <tr>
        <td>
            <input type="hidden" name="product_id[]" class="product_id">
          <input type="text" class="form-control productSearch" placeholder="Enter product name..." autocomplete="off">
          <ul class="searchResults list-group mt-1"></ul>
        </td>
        <td class="uom border">
            <input type="hidden"  name="brand[]" class="product_id">
            <input type="text" class="form-control" readonly>
        </td>
        <td><input type="number" step="0.01" name="price[]" class="form-control price" value="" ></td>
        <td><input type="number" step="0.01" name="item_disc[]" class="form-control item_disc" value=""></td>
        <td class="qty"><input type="number" name="qty[]" class="form-control quantity" value="1" min="1"></td>
        <td class="total border"><input type="text" name="total[]" class="form-control row-total" readonly></td>
        <td><button type="button" class="btn btn-sm btn-danger remove-row">X</button></td>
      </tr>`;
                $('#purchaseItems').append(newRow);
            }

            // ---------- Product Search (AJAX) ----------
            $(document).on('keyup', '.productSearch', function(e) {
                const $input = $(this);
                const q = $input.val().trim();
                const $row = $input.closest('tr');
                const $box = $row.find('.searchResults');

                // Keyboard navigation (Arrow Up/Down + Enter)
                const isNavKey = ['ArrowDown', 'ArrowUp', 'Enter'].includes(e.key);
                if (isNavKey && $box.children('.search-result-item').length) {
                    const $items = $box.children('.search-result-item');
                    let idx = $items.index($items.filter('.active'));
                    if (e.key === 'ArrowDown') {
                        idx = (idx + 1) % $items.length;
                        $items.removeClass('active');
                        $items.eq(idx).addClass('active');
                        e.preventDefault();
                        return;
                    }
                    if (e.key === 'ArrowUp') {
                        idx = (idx <= 0 ? $items.length - 1 : idx - 1);
                        $items.removeClass('active');
                        $items.eq(idx).addClass('active');
                        e.preventDefault();
                        return;
                    }
                    if (e.key === 'Enter') {
                        if (idx >= 0) {
                            $items.eq(idx).trigger('click');
                        } else if ($items.length === 1) {
                            $items.eq(0).trigger('click');
                        }
                        e.preventDefault();
                        return;
                    }
                }

                // Normal fetch
                if (q.length === 0) {
                    $box.empty();
                    return;
                }

                $.ajax({
                    url: "{{ route('search-products') }}",
                    type: 'GET',
                    data: {
                      q
                    },
                    success: function(data) {
                        console.log(data);

                        let html = '';
                       (data || []).forEach(p => {
    const brand = p.brand?.name ?? '';
    const price = p.latest_price?.purchase_net_amount ?? 0;
    const name = p.name ?? '';
    const id = p.id ?? '';

    html += `
      <li class="list-group-item search-result-item"
          tabindex="0"
          data-product-id="${id}"
          data-product-name="${name}"
          data-product-uom="${brand}"
          data-price="${price}">
        ${name} - Rs. ${price}
      </li>`;
});

                        $box.html(html);

                        // first item active for quick Enter
                        $box.children('.search-result-item').first().addClass('active');
                    },
                    error: function() {
                        $box.empty();
                    }
                });
            });

            // Click/Enter on suggestion
            $(document).on('click', '.search-result-item', function() {
                const $li = $(this);
                const $row = $li.closest('tr');

                $row.find('.productSearch').val($li.data('product-name'));
                // $row.find('.item_code input').val($li.data('product-code'));
                $row.find('.uom input').val($li.data('product-uom'));
                // $row.find('.unit input').val($li.data('product-unit'));
                $row.find('.price').val($li.data('price'));

                $row.find('.product_id').val($li.data('product-id'));

                // reset qty & discount for fresh calc
                $row.find('.quantity').val(1);
                $row.find('.item_disc').val(0);

                recalcRow($row);
                recalcSummary();

                // clear results
                $row.find('.searchResults').empty();

                // append new blank row and focus its search
                appendBlankRow();
                $('#purchaseItems tr:last .productSearch').focus();
            });

            // Also allow keyboard Enter selection when list focused
            $(document).on('keydown', '.searchResults .search-result-item', function(e) {
                if (e.key === 'Enter') {
                    $(this).trigger('click');
                }
            });

            // Row calculations
            $('#purchaseItems').on('input', '.quantity, .price, .item_disc', function() {
                const $row = $(this).closest('tr');
                recalcRow($row);
                recalcSummary();
            });

            // Remove row
            $('#purchaseItems').on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                recalcSummary();
            });

            // Summary inputs
            $('#overallDiscount, #extraCost').on('input', function() {
                recalcSummary();
            });

            // init first row values
            recalcRow($('#purchaseItems tr:first'));
            recalcSummary();
        });
    </script>



