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
            $table->string('entity_name');
            $table->enum('entity_type', ['Customer', 'Supplier']);
            $table->enum('type', ['In', 'Out']);
            $table->enum('status', ['Completed', 'Pending', 'Cancelled']);
            $table->enum('payment_method', ['DEBIT', 'CASH']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('pay_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
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
