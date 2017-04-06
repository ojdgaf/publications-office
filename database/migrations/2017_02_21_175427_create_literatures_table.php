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
            $table->smallIncrements('id');
            $table->string('title', 150)->unique();
            $table->text('description')->nullable();
            $table->string('publisher', 150);
            $table->enum('type', Literature::getLiteratureTypes());

            // < Journals >
            $table->enum('periodicity', Literature::getLiteraturePeriodicities())->nullable();
            $table->string('issn', 9)->unique()->nullable();

            // < Books / Conference proceedings >
            $table->unsignedInteger('size')->nullable();
            $table->unsignedInteger('issue_year')->nullable();
            $table->string('isbn', 17)->unique()->nullable();
            
            $table->timestamps();       
        });
    }

    public function down()
    {
        Schema::dropIfExists('literature');
    }
}
