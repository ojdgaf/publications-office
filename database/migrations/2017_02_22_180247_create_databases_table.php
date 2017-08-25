<?php

use App\Database;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabasesTable extends Migration
{
    public function up()
    {
        Schema::create('databases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 180)->unique();
            $table->text('description')->nullable();
            $table->string('url', 180)->unique()->nullable();
            $table->enum('access_mode', Database::getDatabaseAccessModes());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('databases');
    }
}
