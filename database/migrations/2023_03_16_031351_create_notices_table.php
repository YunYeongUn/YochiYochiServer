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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('notice_title', '100')->nullable();
            $table->string('notice_content', '10000')->nullable();
            $table->string('attachment', '2000')->nullable();
            $table->unsignedBigInteger('category');
            $table->timestamps();

            $table->foreign('category')->references('id')->on('noticecategories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
};