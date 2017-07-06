<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoverpathColToLiterature extends Migration
{
    public function up()
    {
        Schema::table('literature', function (Blueprint $table) {
            $table->string('cover_path', 180)->nullable()->after('isbn');
        });
    }

    public function down()
    {
        Schema::table('literature', function (Blueprint $table) {
            $table->dropColumn('cover_path');
        });
    }
}
