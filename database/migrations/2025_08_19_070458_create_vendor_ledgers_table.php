<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('vendor_ledgers', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('vendor_id');
        $table->unsignedBigInteger('admin_or_user_id')->nullable();
        $table->date('date')->nullable();
        $table->string('description')->nullable();
        $table->decimal('debit', 10, 2)->nullable();  // You owe vendor
        $table->decimal('credit', 10, 2)->nullable(); // Vendor paid/adjusted
        $table->decimal('previous_balance', 10, 2)->nullable();
        $table->decimal('closing_balance', 10, 2)->nullable();
        $table->timestamps();

        $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_ledgers');
    }
};
