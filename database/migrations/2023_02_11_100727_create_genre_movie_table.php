<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
	public function up()
	{
		Schema::create('genre_movie', function (Blueprint $table) {
			$table->foreignId('genre_id');
			$table->foreignId('movie_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('genre_movie');
	}
};
