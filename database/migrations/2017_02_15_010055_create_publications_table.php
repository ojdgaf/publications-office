<?php

use App\Publication;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('heading', 150)->unique();
            $table->text('abstract');
            $table->text('description');
            $table->enum('genre', Publication::getPublicationGenres());
            $table->enum('type', Publication::getPublicationTypes());
            $table->unsignedInteger('literature_id');
            // < Journal articles>
            $table->enum('issue_number', Publication::getPublicationIssueNumbers())->nullable();
            $table->unsignedInteger('issue_year')->nullable();

            // < Journal articles / Reports of conferences >
            $table->unsignedInteger('page_initial')->nullable();
            $table->unsignedInteger('page_final')->nullable();

            $table->string('document_path', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publications');
    }
}