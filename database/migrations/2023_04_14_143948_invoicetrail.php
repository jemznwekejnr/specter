<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Invoicetrail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoicetrail', function (Blueprint $table) {
            $table->id();
            $table->string("invoiceid");
            $table->string("invoicetype");
            $table->string("changes")->nullable();
            $table->string("status")->nullable();
            $table->string("remark")->nullable();
            $table->string("actor");
            $table->string("actor_type");
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
        Schema::dropIfExists('invoicetrail');
    }
}
