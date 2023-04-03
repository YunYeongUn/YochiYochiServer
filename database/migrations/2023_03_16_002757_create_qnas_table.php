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
        Schema::create('qnas', function (Blueprint $table) {
            $table->id();
            $table->string('qna_title', '100')->nullable();
            $table->string('qna_content', '10000')->nullable();
            $table->string('attachment', '2000')->nullable();
            $table->boolean('answer')->default(0);
            $table->unsignedBigInteger('writer');
            $table->unsignedBigInteger('category');
            $table->timestamps();

            $table->foreign('writer')->references('id')->on('users');
            $table->foreign('category')->references('id')->on('qnacategories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qnas');
    }
};