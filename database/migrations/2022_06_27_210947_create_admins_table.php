<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->string('email', 50)->unique();
            $table->string('phone', 15)->unique();
            $table->string('password', 100);
            $table->string('image', 191)->nullable();
            $table->date('dob');
            $table->integer('gender')->default(1)->comment('1 male , 2 female');
            $table->integer('type')->default(1)->comment('1 main admin ,2 supervisor');
            $table->tinyInteger('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('admins');
    }
}
