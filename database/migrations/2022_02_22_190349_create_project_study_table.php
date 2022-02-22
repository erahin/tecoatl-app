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
        Schema::create('project_study', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('project_id')
                ->nullable()
                ->constrained('project')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('study_id')
                ->nullable()
                ->constrained('study')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
        Schema::dropIfExists('project_study');
    }
}
