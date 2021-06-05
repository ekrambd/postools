<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->string('order_session_id');
            $table->string('product_id')->nullable();
            $table->string('order_variant_id')->nullable();
            $table->string('customer_id');
            $table->string('order_total');
            $table->string('order_sub_total');
            $table->string('discount')->nullable();
            $table->string('amount');
            $table->string('order_date');
            $table->string('order_month');
            $table->string('order_year');
            $table->string('order_status')->default('1');
            $table->string('pay');
            $table->string('due');
            $table->string('payby');
            $table->string('order_return_total')->nullable();
            $table->string('return_pay')->nullable();
            $table->string('return_due')->nullable();
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
}
