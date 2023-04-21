<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Receipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt', function (Blueprint $table) {
            $table->id();
            $table->string("sentform");
            $table->string("title");;
            $table->string("clientinfo");
            $table->string("body", 5000);
            $table->string("status");
            $table->string("sendto");
            $table->string("copies")->nullable();
            $table->double("totalprice");
            $table->double("totalvat");
            $table->double("totalwht");
            $table->double("totalamount");
            $table->string("accountno");
            $table->string("accountname");
            $table->string("bank");
            $table->string("amountinwords");
            $table->string("project");
            $table->string("status");
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
        Schema::dropIfExists('receipt');
    }
}
