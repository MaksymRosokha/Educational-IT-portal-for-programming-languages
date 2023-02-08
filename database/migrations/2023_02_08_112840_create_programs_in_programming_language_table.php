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
        Schema::create('programs_in_programming_language', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programming_language_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name', 200);
            $table->string('image', 300)->default('default/defaultProgramInProgrammingLanguageImage.png')->nullable();
            $table->text('description');
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
        Schema::dropIfExists('programs_in_programming_language');
    }
};
