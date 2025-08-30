<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'manual_invoice',
        'customer_id',
        'sub_customer',
        'filer_type',
        'address',
        'tel',
        'remarks',
        'sub_total1',
        'sub_total2',
        'discount_percent',
        'discount_amount',
        'previous_balance',
        'total_balance',
        'receipt1',
        'receipt2',
        'final_balance1',
        'final_balance2',
        'weight',
    ];

    // Relation to sale items
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Relation to Customer (agar model hai)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
