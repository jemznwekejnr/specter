<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pv', function (Blueprint $table) {
            $table->id();
            $table->string("sentform");
            $table->string("title");
            $table->string("body", 5000);
            $table->string("attachment")->nullable();
            $table->string("status");
            $table->string("sendto");
            $table->string("copies")->nullable();
            $table->double("totalprice");
            $table->double("totalvat");
            $table->double("totalamount");
            $table->double("totalgross");
            $table->double("totalwht");
            $table->double("totalnet");
            $table->string("accountno");
            $table->string("accountname");
            $table->string("bank");
            $table->string("amountinwords");
            $table->string("project");
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
        Schema::dropIfExists('pv');
    }
}
