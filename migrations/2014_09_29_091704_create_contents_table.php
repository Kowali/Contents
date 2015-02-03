<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contents', function(Blueprint $table)
		{
            // Object identity
			$table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            // Object's parent (optional)
            $table->integer('content_id')->unsigned()->nullable();

            // Object fields
            $table->integer('order')->unsigned()->default(0);
            $table->text('_content')->nullable();
            $table->string('content_model');
            $table->string('status')->default('draft');

            // Object behaviours
            $table->nullableTimestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('content_id')
                ->references('id')
                ->on('contents')
                ->onUpdate('cascade')
                ->onDelete('set null');
		});

        Schema::create('content_translations', function(Blueprint $table)
        {
            // Object identity
			$table->increments('id');
            $table->integer('content_id')->unsigned();
            $table->string('locale')->index();

            // Translated fields
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('mime_type')->default('text/x-markdown');

            // Object behaviours
            $table->timestamps();

            // Foreign keys
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
		Schema::drop('content_translations');
		Schema::drop('contents');
	}

}
