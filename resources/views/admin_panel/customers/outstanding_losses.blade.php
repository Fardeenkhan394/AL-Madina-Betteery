@extends('admin_panel.layout.app')
@section('content')
<style>
    .btn-sm i.fa-toggle-on {
        color: green;
        font-size: 20px;
    }

    .btn-sm i.fa-toggle-off {
        color: gray;
        font-size: 20px;
    }
</style>

    <div class="main-content">
        <div class="main-content-inner">
            <div class="container">
  <h3>Our dieuse</h3>
  <a href="{{ route('customers.inactive') }}" class="btn btn-secondary mb-3 float-end">View Inactive Customers</a>

    <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">+ Add New Customer</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
         <th>Customer ID</th>
                <th>Name</th>
                <th>Outstanding Amount</th>
                <th>Reason</th>
                <th>Date</th>
            </tr>
        </thead>
          <tbody>
            @foreach($losses as $loss)
            <tr>
                <td>{{ $loss->customer->customer_id ?? '-' }}</td>
                <td>{{ $loss->customer->customer_name ?? 'N/A' }}</td>
                <td>Rs. {{ number_format($loss->amount, 2) }}</td>
                <td>{{ $loss->reason }}</td>
                <td>{{ $loss->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
      
    </table>

            </div>
        </div>
    </div>
@endsection
