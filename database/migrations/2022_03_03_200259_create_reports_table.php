<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('report_number');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('report_type');
            $table
                ->foreignId('project_id')
                ->nullable()
                ->constrained('projects')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('studio_id')
                ->nullable()
                ->constrained('studies')
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
        Schema::dropIfExists('reports');
    }
}
