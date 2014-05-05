<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('votable_id')->unsigned();
			$table->string('votable_name',255);
			$table->integer('voter_id')->unsigned();
			$table->string('voter_name',255);
			
			$table->integer('value');
			$table->integer('min_value');
			$table->integer('max_value');
			
			$table->index('votable_id');
			$table->index('votable_name');
			$table->index('voter_id');
			$table->index('voter_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('votes');
	}

}