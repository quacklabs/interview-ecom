<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('account_id');
            $table->decimal('price_amount', 28,8);
            $table->decimal('pay_amount', 28,8);
            $table->string('price_currency');
            $table->string('pay_currency');
            $table->string('order_id')->nullable();
            $table->string('order_description')->nullable();
            $table->unsignedBigInteger('sub_id')->nullable();
            $table->boolean('is_debit');
            $table->string('payment_status');
            $table->string('network')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
