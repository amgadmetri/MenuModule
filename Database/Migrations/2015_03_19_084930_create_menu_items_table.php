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
				$table->bigInteger('menu_id');	
				$table->string('title', 150)->index();
				$table->string('link', 150)->default('#')->index();
				$table->enum('status', ['published', 'unpublished'])->default('published');
				$table->bigInteger('parent_id');
				$table->enum('target', ['_parent', '_blank', '_top', '_self']);
				$table->bigInteger('display_order');
				$table->bigInteger('user_id');
				$table->timestamps();
			});


			\CMS::menuItems()->insert(
				[
					[
						'menu_id'       => 1,
						'title'         => 'Home',
						'link'          => url('/'),
						'status'        => 'published',
						'parent_id'     => 0,
						'target'        => '_self',
						'display_order' => 1,
						'user_id'       => 1,
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
		if (Schema::hasTable('menu_items'))
		{
			Schema::drop('menu_items');
		}
	}
}