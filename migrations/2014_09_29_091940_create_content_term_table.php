<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentTermTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('content_term', function(Blueprint $table)
		{
			$table->increments('id');

            $table->integer('term_id')->unsigned();
            $table->integer('content_id')->unsigned();

            $table->foreign('term_id')
                ->references('id')
                ->on('terms')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onUpdate('cascade')
                ->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('content_term');
	}

}
