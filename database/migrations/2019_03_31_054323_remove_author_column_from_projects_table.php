<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAuthorColumnFromProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('projects', 'authors')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('authors');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasColumn('projects', 'authors')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->text('authors')->nullable();
            });
        }
    }
}
