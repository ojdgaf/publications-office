<?php

use App\Literature;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiteraturesTable extends Migration
{
    public function up()
    {
        Schema::create('literature', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 180)->unique();
            $table->text('description')->nullable();
            $table->string('publisher', 180);
            $table->enum('type', Literature::getLiteratureTypes());

            // < Journals >
            $table->enum('periodicity', [12, 6, 4, 3, 2, 1])->nullable();
            $table->string('issn', 9)->unique()->nullable();

            // < Books / Conference proceedings >
            $table->unsignedInteger('size')->nullable();
            $table->unsignedInteger('issue_year')->nullable();
            $table->string('isbn', 17)->unique()->nullable();

            $table->string('cover_path', 180)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('literature');
    }
}
