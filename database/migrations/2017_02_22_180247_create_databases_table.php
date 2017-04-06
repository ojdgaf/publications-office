<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabasesTable extends Migration
{
    public function up()
    {
        Schema::create('databases', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 150)->unique();
            $table->text('description')->nullable();
            $table->string('url')->unique()->nullable();
            $table->string('access_mode', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('databases');
    }
}
