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
				$table->increments('id');
				$table->integer('menu_id');	
				$table->string('title')->index();
				$table->string('link')->default('#')->index();
				$table->enum('status', ['published', 'unpublished'])->default('published');
				$table->integer('parent_id');
				$table->enum('target', ['_parent', '_blank', '_top', '_self']);
				$table->integer('display_order');
				$table->integer('user_id');
				$table->timestamps();
			});


			DB::table('menu_items')->insert([
				array(
					'menu_id'       => 1,
					'title'         => 'Home',
					'link'          => url('/'),
					'status'        => 'published',
					'parent_id'     => 0,
					'target'        => '_self',
					'display_order' => 1,
					'user_id'       => 1,
					),
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