<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    use HasFactory;

  protected $fillable = [
    'from_warehouse_id',
    'to_warehouse_id',
    'to_shop',
    'product_id',
    'quantity',
    'remarks',
];


    public function fromWarehouse() {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse() {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
