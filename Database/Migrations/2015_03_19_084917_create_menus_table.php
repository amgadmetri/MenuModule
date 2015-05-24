<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('menus'))
		{
			Schema::create('menus', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('title', 150)->unique();
				$table->string('menu_slug', 150)->unique()->index();	
				$table->string('description', 255)->index();
				$table->boolean('is_active')->default(1);
				$table->timestamps();
			});

			\CMS::menus()->insert(
				[
					[
						'title'       => 'Main Menu',
						'menu_slug'   => 'mainmenu',
						'description' => 'contain the main menus for the header',
						'is_active'   => 1,
					],
				]
				);
		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('menus'))
		{
			Schema::drop('menus');
		}
	}
}