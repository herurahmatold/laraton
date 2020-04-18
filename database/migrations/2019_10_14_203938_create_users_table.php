<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('laraton_users', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name');
			$table->string('username', 30)->index('username');
			$table->string('email', 50)->index('email');
			$table->dateTime('email_verified_at')->nullable();
			$table->string('password');
			$table->integer('user_group_id')->index('user_group_id');
			$table->boolean('status')->default(0);
			$table->string('avatar', 100)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->dateTime('last_login')->nullable();
			$table->timestamps();
			$table->boolean('isDeleted');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('laraton_users');
	}

}
