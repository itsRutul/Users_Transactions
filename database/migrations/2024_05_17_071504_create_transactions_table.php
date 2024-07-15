<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->decimal('amount', 15, 2);
                $table->enum('currency', ['INR', 'USD', 'AUD']);
                $table->boolean('status')->default(1);
                $table->enum('paymethod', ['cash', 'cheque', 'online']);
                $table->timestamp('datetime')->useCurrent();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}

