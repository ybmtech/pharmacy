<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->string('tracking_no');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('prescription_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('total');
             $table->enum('status',['pending','on transit','delivered','cancelled','processing'])->default('pending');
             $table->enum('payment_status',['not paid','paid'])->default('not paid');
            $table->longText('delivery_address');
            $table->decimal('delivery_fee')->default(0);
            $table->string('weight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
