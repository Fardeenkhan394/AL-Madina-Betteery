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
    Schema::create('vendor_payments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('vendor_id');
        $table->unsignedBigInteger('admin_or_user_id')->nullable();
        $table->decimal('amount', 10, 2);
        $table->string('payment_method')->nullable();
        $table->date('payment_date')->nullable();
        $table->text('note')->nullable();
        $table->timestamps();

        $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_payments');
    }
};
