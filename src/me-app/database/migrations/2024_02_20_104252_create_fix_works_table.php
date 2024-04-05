<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fix_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('break_time');
            $table->time('result_time');
            $table->string('salary');
            $table->date('date');
            $table->foreignId('customer_id')
                ->nullable()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->boolean('necessity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fix_works');
    }
};
