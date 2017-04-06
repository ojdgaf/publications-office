<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdColToLiteratureDatabases extends Migration
{
    public function up()
    {
        Schema::table('database_literature', function (Blueprint $table) {
            $table->smallIncrements('id')->first();
        });
    }

    public function down()
    {
        Schema::table('database_literature', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}
