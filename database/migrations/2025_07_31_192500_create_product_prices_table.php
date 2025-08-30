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
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');

            $table->decimal('purchase_retail_price', 10, 2);
            $table->decimal('purchase_tax_percent', 15, 2);
            $table->decimal('purchase_tax_amount', 15, 2);
            $table->decimal('purchase_discount_percent', 15, 2);
            $table->decimal('purchase_discount_amount', 15, 2);
            $table->decimal('purchase_net_amount', 15, 2);
            $table->decimal('sale_retail_price', 15, 2);
            $table->decimal('sale_tax_percent', 15, 2);
            $table->decimal('sale_tax_amount', 15, 2);
            $table->decimal('sale_wht_percent', 15, 2);
            $table->decimal('sale_discount_percent', 15, 2);
            $table->decimal('sale_discount_amount', 15, 2);
            $table->decimal('sale_net_amount', 15, 2);
            // $table->date('effective_date');
            $table->date('effective_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
