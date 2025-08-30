<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\VendorLedger;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorPayment;
class VendorController extends Controller
{
    // VendorController.php aur WarehouseController.php same hoga
public function index() {
    $vendors = Vendor::all(); // ya $warehouses = Warehouse::all();
    return view('admin_panel.vendors.index', compact('vendors')); // ya warehouses.index
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'nullable|email',
        'phone' => 'nullable|string',
        'address' => 'nullable|string',
        'debit' => 'nullable|numeric',
        'credit' => 'nullable|numeric',
    ]);

    $userId = Auth::id(); // Current admin/user

    if ($request->id) {
        // Update vendor
        $vendor = Vendor::findOrFail($request->id);
        $vendor->update($request->all());

        // Optional: Update opening ledger entry here if needed
    } else {
        // New vendor
        $vendor = Vendor::create($request->all());

        $debit = floatval($request->debit ?? 0);
        $credit = floatval($request->credit ?? 0);
        $closing = $debit - $credit;

        if ($debit > 0 || $credit > 0) {
            VendorLedger::create([
                'vendor_id' => $vendor->id,
                'admin_or_user_id' => $userId,
                'date' => now(),
                'description' => 'Opening Balance',
                'debit' => $debit,
                'credit' => $credit,
                'previous_balance' => 0,
                'closing_balance' => $closing,
            ]);
        }
    }

    return back()->with('success', 'Saved Successfully');
}


public function delete($id) {
    Vendor::findOrFail($id)->delete();
    return back()->with('success', 'Deleted Successfully');
}

public function allLedgers()
{
    $ledgers = VendorLedger::with('vendor')->orderBy('date')->get();

    return view('admin_panel.vendors.ledger', compact('ledgers'));
}
public function payments_index()
{
    $payments = VendorPayment::with('vendor')->latest()->get();
    $vendors = Vendor::all();
    return view('admin_panel.vendors.payments', compact('payments', 'vendors'));
}

public function payments_store(Request $request)
{
    $request->validate([
        'vendor_id' => 'required|exists:vendors,id',
        'amount' => 'required|numeric|min:0',
        'payment_method' => 'nullable|string',
        'payment_date' => 'required|date',
        'note' => 'nullable|string',
    ]);

    $userId = Auth::id();

    $payment = VendorPayment::create([
        'vendor_id' => $request->vendor_id,
        'admin_or_user_id' => $userId,
        'amount' => $request->amount,
        'payment_method' => $request->payment_method,
        'payment_date' => $request->payment_date,
        'note' => $request->note,
    ]);

    // Ledger Entry
    $previous = VendorLedger::where('vendor_id', $request->vendor_id)->latest()->first();
    $prevBalance = $previous->closing_balance ?? 0;
    $newClosing = $prevBalance - $request->amount;

    VendorLedger::create([
        'vendor_id' => $request->vendor_id,
        'admin_or_user_id' => $userId,
        'date' => $request->payment_date,
        'description' => 'Payment Received',
        'debit' => 0,
        'credit' => $request->amount,
        'previous_balance' => $prevBalance,
        'closing_balance' => $newClosing,
    ]);

    return back()->with('success', 'Payment recorded successfully.');
}

}
