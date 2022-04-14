<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStudyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects_studies', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('project_id')
                ->nullable()
                ->constrained('projects')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table
                ->foreignId('study_id')
                ->nullable()
                ->constrained('studies')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->integer('projects_studies_id')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects_studies');
    }
}
