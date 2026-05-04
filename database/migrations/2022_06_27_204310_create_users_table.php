<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('image', 191)->nullable();
            $table->string('ID_Number')->nullable();
            $table->string('referral_code')->nullable();
            $table->bigInteger('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
            $table->date('dob')->nullable();
            $table->double('lat', 50)->default(0.0)->nullable();
            $table->double('lng', 50)->default(0.0)->nullable();
            $table->string('address', 191)->nullable();
            $table->integer('gender')->default(1)->nullable()->comment('1 male, 2 female ,3 other');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('platform')->default(1)->comment('1 android ,2 ios');
            $table->string('device_token', 255)->nullable();
            $table->string('jwt_token', 255)->unique();
            $table->longText('info')->nullable();
            $table->longText('firebase_token')->nullable();


            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
