<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('options_laraton', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('option_key', 50)->index('option_key');
			$table->text('option_value', 65535)->nullable();
			$table->boolean('is_sistem')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('options_laraton');
	}

}
