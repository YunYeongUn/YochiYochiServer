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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_title', '100')->nullable();
            $table->string('post_content', '10000')->nullable();
            $table->string('attachment', '2000')->nullable();
            $table->unsignedBigInteger('writer');
            $table->integer('views')->default(0);
            $table->timestamps();

            $table->foreign('writer')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};