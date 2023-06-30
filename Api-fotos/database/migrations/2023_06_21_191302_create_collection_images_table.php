<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionImagesTable extends Migration
{
    public function up()
    {
        Schema::create('collection_images', function (Blueprint $table) {
            $table->id();
            $table->uuid('image_id');
            $table->foreign('image_id')->references('id')->on('images');
            $table->uuid('collection_id');
            $table->foreign('collection_id')->references('id')->on('collections');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collection_images');
    }
}

