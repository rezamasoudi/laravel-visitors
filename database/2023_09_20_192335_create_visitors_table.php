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
        Schema::dropIfExists('visitors');
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string("visitable")->nullable();
            $table->string("visitable_id")->nullable();
            $table->string('auth_id')->nullable();
            $table->string('ip')->nullable()->index();
            $table->string('referer')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('path')->nullable();
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
        Schema::dropIfExists('visitors');
    }
};
