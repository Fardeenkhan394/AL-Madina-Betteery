<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('purchases', function (Blueprint $table) {
           $table->id();

            $table->foreignId('branch_id');
            $table->foreignId('warehouse_id');
            // $table->foreignId('vendor_id');
            $table->morphs('purchasable');

            $table->date('current_date')->nullable();
            $table->date('dc_date')->nullable();
            $table->string('invoice_no')->nullable();
            $table->text('note')->nullable();
            $table->text('vendor_id')->nullable();

            // Totals
            $table->decimal('subtotal',   12, 2)->default(0);
            $table->decimal('discount',   12, 2)->default(0);
            $table->decimal('wht', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2)->default(0);
            $table->decimal('paid_amount',12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);

            $table->timestamps();
            $table->softDeletes();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
