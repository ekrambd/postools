<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('cart_pro_name');
            $table->string('cart_pro_price');
            $table->string('product_id')->nullable();
            $table->string('cart_variant_id')->nullable();
            $table->string('qty');
            $table->string('cart_session_id');
            $table->string('amount');
            $table->string('return_qty')->nullable();
            $table->string('return_amount')->nullable();
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
        Schema::dropIfExists('carts');
    }
}
