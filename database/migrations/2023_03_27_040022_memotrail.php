<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Memotrail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memotrail', function (Blueprint $table) {
            $table->id();
            $table->string("memoid");
            $table->string("title")->nullable();
            $table->string("body", 2000)->nullable();
            $table->string("attachment")->nullable();
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
        Schema::dropIfExists('memotrail');
    }
}
