<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Circular extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circular', function (Blueprint $table) {
            $table->id();
            $table->integer("sentform");
            $table->string("total_recipient");
            $table->string("title");
            $table->string("body", 5000);
            $table->string("attachment")->nullable();
            $table->string("status");
            $table->integer("reacted_by")->nullable();
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
        Schema::dropIfExists('circular');
    }
}
