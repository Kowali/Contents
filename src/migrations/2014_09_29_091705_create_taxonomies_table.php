<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxonomiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('taxonomies', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('slug')->unique();
			$table->timestamps();
		});

        Schema::create('taxonomy_translations', function(Blueprint $table)
        {
			$table->increments('id');
            $table->integer('taxonomy_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
			$table->timestamps();

            $table->unique(['taxonomy_id', 'locale']);

            $table->foreign('taxonomy_id')
                ->references('id')
                ->on('taxonomies')
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
		Schema::drop('taxonomy_translations');
		Schema::drop('taxonomies');
	}

}
