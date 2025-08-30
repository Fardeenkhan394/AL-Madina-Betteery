<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IncentiveController extends Controller
{
    public function index()
    {
        return view('admin_panel.accounts.incentive');
    }
    public function reciepts_vouchers()
    {
        return view('admin_panel.accounts.reciepts_vouchers');
        return view('admin_panel.accounts.incentive');
    }
}
