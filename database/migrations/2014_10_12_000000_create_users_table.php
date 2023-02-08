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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email', 320)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('login', 50)->unique();
            $table->string('password');
            $table->string('name', 200)->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('admin')->default(false);
            $table->timestamp("blocked_until")->nullable()->default(null);
            $table->date('date_of_birthday')->nullable()->default(null);
            $table->string('avatar', 300)
                ->default('default/defaultUserAvatar.png')
                ->nullable();
            $table->text('about_me')->nullable()->default(null);
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
