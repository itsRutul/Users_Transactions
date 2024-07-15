<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->text('introduction')->nullable();
            $table->decimal('deposit', 15, 2);
            $table->decimal('total_confirmed_amount', 15, 2);
            $table->enum('currency', ['INR', 'USD', 'AUD'])->default('USD');
            $table->boolean('status')->default(true);
            $table->date('due_date')->default(now()); // Set default value to current date
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

