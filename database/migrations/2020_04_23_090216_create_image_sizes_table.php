<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_sizes', function (Blueprint $table) {
            //Foreign Key
            $table->unsignedBigInteger('image_id');
            $table->foreign('image_id')->references('id')->on('images');
            
            $table->integer('width');
            $table->string('url');
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
        Schema::dropIfExists('image_sizes');
    }
}
