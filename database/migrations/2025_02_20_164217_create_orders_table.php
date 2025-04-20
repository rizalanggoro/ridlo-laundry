<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id');
            $table->uuid('laundry_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('laundry_id')->references('id')->on('laundries')->onDelete('cascade');
            $table->enum('status', ['pending', 'washed', 'dried', 'ironed', 'ready_picked', 'completed', 'cancelled'])->default('pending');
            $table->enum('type', ['express', 'regular', 'kiloan', 'satuan']);
            $table->string('barcode')->unique();
            $table->decimal('weight', 8, 2);
            $table->decimal('total_price', 10, 2);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
