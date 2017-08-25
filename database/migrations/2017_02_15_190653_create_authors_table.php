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
            $table->increments('id');
            $table->string('name', 150);
            $table->string('email', 150)->unique()->nullable();
            $table->enum('status', Author::getAuthorStatuses())->default('other');

            // < Students / Staff >
            $table->enum('degree', Author::getAuthorDegrees())->nullable();

            // < Staff >
            $table->enum('rank', Author::getAuthorRanks())->nullable();
            $table->string('post', 150)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('authors');
    }
}
