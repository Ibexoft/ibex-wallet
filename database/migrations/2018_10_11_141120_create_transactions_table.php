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
            $table->foreignId('user_id');
            $table->string('type');
            $table->float('amount', 8, 2);
            $table->date('transaction_date');
            $table->foreignId('category_id')->nullable();
            $table->foreignId('src_account_id')->constrained('accounts');
            $table->foreignId('dest_account_id')->nullable()->constrained('accounts');
            $table->string('details')->nullable();
            $table->string('spent_on')->nullable();
            $table->foreignId('wallet_id')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
