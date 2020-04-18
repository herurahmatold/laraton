<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePageAccessDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('page_access_detail_laraton', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('page_access_id')->index('page_access_id');
			$table->integer('user_group_id')->index('user_group_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('page_access_detail_laraton');
	}

}
