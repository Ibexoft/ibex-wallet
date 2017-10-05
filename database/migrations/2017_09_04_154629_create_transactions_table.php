<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_id');
            $table->float('amount', 8, 2);
            $table->string('description');
            $table->enum('type', [
                'expense', 'return', 'lend', 'settlement w',    // withdrawals
                'income', 'refund', 'settlement d', 'borrow',   // deposits
                'transfer']);
            $table->integer('from_account_id')->nullable();
            $table->integer('to_account_id')->nullable();
            $table->string('for_whom')->nullable();
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
