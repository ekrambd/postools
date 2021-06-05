<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('variant_id')->nullable();
            $table->string('var_name')->nullable();
            $table->string('product_name')->nullable();
            $table->string('var_sku')->nullable();
            $table->string('var_price')->nullable();
            $table->string('var_value')->nullable();
            $table->string('stock')->default('0');
            $table->string('var_image')->nullable();
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
        Schema::dropIfExists('variants');
    }
}
