<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_sheets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('drs_no');
            $table->longText('transaction_details')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_no')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('transaction_sheets');
    }
}
