<?php

use App\Author;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsTable extends Migration
{
    public function up()
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name', 50);
            $table->string('email', 50)->unique()->nullable();
            $table->enum('status', Author::getAuthorStatuses())->default('other');

            // < Students / Staff >
            $table->enum('degree', Author::getAuthorDegrees())->nullable();

            // < Staff >
            $table->enum('rank', Author::getAuthorRanks())->nullable();
            $table->string('post', 100)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
