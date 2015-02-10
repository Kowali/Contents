<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMetasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('metas', function(Blueprint $table)
		{
            // Object indentity
			$table->increments('id');
            $table->string('key');
            $table->string('lang')->nullable();
            $table->text('value');
            $table->string('metaable_type');
            $table->integer('metaable_id')->unsigned();

            $table->unique(['key', 'lang', 'metaable_type', 'metaable_id']);
            // Object behaviours
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
		Schema::drop('metas');
	}

}
