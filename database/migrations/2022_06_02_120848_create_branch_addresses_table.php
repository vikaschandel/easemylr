<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('gst_number');
            $table->string('phone');
            $table->string('address');
            $table->string('state');
            $table->string('district');
            $table->string('city');
            $table->string('postal_code');
            $table->string('email');
            $table->string('status');
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
        Schema::dropIfExists('branch_addresses');
    }
}
