<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Profile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string("userid")->nullable();
            $table->string("staffid");
            $table->string("surname");
            $table->string("firstname");
            $table->string("othername")->nullable();
            $table->string("email");
            $table->string("phone");
            $table->string("dob");
            $table->string("doe");
            $table->string("department");
            $table->string("designation");
            $table->string("office")->nullable();
            $table->string("gender");
            $table->string("employmentstatus");
            $table->date("datechanged");
            $table->string("accountno")->nullable();
            $table->string("bankname")->nullable();
            $table->string("image")->nullable();
            $table->string("signature")->nullable();
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
        Schema::dropIfExists('profile');
    }
}
