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
            $table->string('name')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('report_type');
            $table->integer('project_id');
            $table
                ->foreignId('studio_id')
                ->nullable()
                ->constrained('studies')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->timestamps();
            $table
                ->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
