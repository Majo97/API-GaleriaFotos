<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->unsignedBigInteger('causer_id')->nullable();
            $table->foreign('causer_id')->references('id')->on('users');
            $table->uuid('object_id');
            $table->string('object_type');
            $table->json('previous_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
