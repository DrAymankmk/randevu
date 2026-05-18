<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();       // 'en', 'ar', 'zh-TW', 'pt-BR'
            $table->string('name');                      // 'English', 'Arabic'
            $table->string('native_name')->nullable();   // 'العربية', '中文'
            $table->string('direction', 3)->default('ltr'); // 'ltr' or 'rtl'
            $table->string('flag')->nullable();          // Flag emoji or icon path
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('is_active');
            $table->index('is_default');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms_languages');
    }
};
