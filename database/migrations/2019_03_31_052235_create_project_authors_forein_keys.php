<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAuthorsForeinKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_authors', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_authors', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
            $table->dropForeign(['project_id']);
        });
    }
}
