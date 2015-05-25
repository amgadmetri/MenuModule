<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('menu_items'))
		{
			Schema::create('menu_items', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->bigInteger('menu_id')->unsigned();
				$table->foreign('menu_id')->references('id')->on('menus');
				$table->string('title', 150)->index();
				$table->string('link', 150)->default('#')->index();
				$table->enum('status', ['published', 'unpublished'])->default('published');
				$table->bigInteger('parent_id')->unsigned();
				$table->enum('target', ['_parent', '_blank', '_top', '_self']);
				$table->string('css_class', 150);
				$table->string('css_attributes', 150);
				$table->bigInteger('display_order')->unsigned();
				$table->bigInteger('user_id')->unsigned();
				$table->foreign('user_id')->references('id')->on('users');
				$table->timestamps();
			});

		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('menu_items'))
		{
			Schema::drop('menu_items');
		}
	}
}