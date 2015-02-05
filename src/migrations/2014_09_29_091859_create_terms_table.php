<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTermsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('terms', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('slug');
            $table->integer('term_id')->unsigned()->nullable();
            $table->integer('taxonomy_id')->unsigned();

            $table->unique(['slug', 'taxonomy_id']);

            $table->foreign('term_id')
                ->references('id')
                ->on('terms')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('taxonomy_id')
                ->references('id')
                ->on('taxonomies')
                ->onUpdate('cascade')
                ->onDelete('cascade');

			$table->timestamps();
		});

		Schema::create('term_translations', function(Blueprint $table)
        {
			$table->increments('id');
            $table->integer('term_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();
			$table->timestamps();

            $table->unique(['term_id', 'locale']);

            $table->foreign('term_id')
                ->references('id')
                ->on('terms')
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
		Schema::drop('term_translations');
		Schema::drop('terms');
	}
}
