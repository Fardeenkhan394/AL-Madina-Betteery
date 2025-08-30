<?php
// app/Models/VendorLedger.php

namespace App\Models;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;

class VendorLedger extends Model
{
    protected $fillable = [
        'vendor_id',
        'admin_or_user_id',
        'date',
        'description',
        'debit',
        'credit',
        'previous_balance',
        'closing_balance',
    ];
    // app/Models/VendorLedger.php

public function vendor()
{
    return $this->belongsTo(Vendor::class);
}

}
