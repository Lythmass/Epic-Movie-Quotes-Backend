<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('movie_id')->constrained();
            $table->text('quote');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quotes');
    }
};
