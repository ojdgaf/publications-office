<?php

use App\Author;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationAuthorsTable extends Migration
{
    public function up()
    {
        Schema::create('author_publication', function (Blueprint $table) {
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('publication_id');
            $table->enum('status_author', Author::getAuthorStatuses())->default('other');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('author_publication');
    }
}
