<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('role');
            $table->string('create_user')->nullable();
            $table->string('pos')->nullable();
            $table->string('customer')->nullable();
            $table->string('supplier')->nullable();
            $table->string('category')->nullable();
            $table->string('product')->nullable();
            $table->string('sale_product')->nullable();
            $table->string('set_order')->nullable();
            $table->string('due_report')->nullable();
            $table->string('sales_report')->nullable();
            $table->string('settings')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
