<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIdColToPublicationsAuthors extends Migration
{
    public function up()
    {
        Schema::table('author_publication', function (Blueprint $table) {
            $table->smallIncrements('id')->first();
        });
    }

    public function down()
    {
        Schema::table('author_publication', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}
