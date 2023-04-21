<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Invoicesheet2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicesheet2', function (Blueprint $table) {
            $table->id();
            $table->string("pvid");
            $table->string("description");
            $table->string("period");
            $table->double("rate");
            $table->integer("hours");
            $table->double("amount");
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
        Schema::dropIfExists('invoicesheet2');
    }
}
