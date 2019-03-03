<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doi')->nullable();
            $table->string('title');
            $table->text('authors');
            $table->text('abstract');
            $table->unsignedInteger('adviser_id');
            $table->unsignedInteger('area_id');
            $table->string('call_number')->nullable();
            $table->date('date_submitted')->nullable();
            $table->text('keywords');
            $table->unsignedInteger('pages');
            $table->year('year_published');
            $table->string('uploaded_file_path');
            $table->timestamps();

            $table->foreign('adviser_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
