<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('programs_in_programming_language')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('test_id');
            $table->integer('sequence_number');
            $table->string('title', 300);
            $table->text('content');
            $table->timestamps();
            $table->unique(['program_id', 'sequence_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};
