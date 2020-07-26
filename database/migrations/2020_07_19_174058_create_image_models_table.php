<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link')->unique();
            $table->unsignedBigInteger('user');
            $table->foreign('user')->references('id')->on('users');
            $table->unsignedBigInteger('category');
            $table->foreign('category')->references('id')->on('categories');
            $table->bigInteger('rating')->nullable();
            $table->bigInteger('rating_count')->nullable();
            $table->bigInteger('views')->nullable();
            $table->boolean('isActive')->default(true);
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
        Schema::dropIfExists('images');
    }
}
