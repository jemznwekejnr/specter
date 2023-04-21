<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Invoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->string("sentform");
            $table->string("invoiceno")->nullable();
            $table->string("clientinfo");
            $table->string("invoicetype");
            $table->string("sendto");
            $table->string("copies")->nullable();
            $table->double("totalprice");
            $table->double("totalvat");
            $table->double("totalwht");
            $table->double("vatp");
            $table->double("whtp");
            $table->double("sumamounts");
            $table->double("totalamount");
            $table->string("accountno");
            $table->string("accountname");
            $table->string("bank");
            $table->string("branch")->nullable();
            $table->string("sortcode")->nullable();
            $table->string("ibanno")->nullable();
            $table->string("amountinwords");
            $table->string("project");
            $table->string("currency");
            $table->string("refno")->nullable();
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
        Schema::dropIfExists('invoice');
    }
}
