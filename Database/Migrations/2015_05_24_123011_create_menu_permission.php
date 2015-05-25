<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuPermission extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		foreach (\CMS::coreModuleParts()->getModuleParts('menus') as $modulePart) 
		{
			\CMS::permissions()->insertDefaultItemPermissions(
				                 $modulePart->part_key, 
				                 $modulePart->id, 
				                 [
					                 'admin'   => ['show', 'add', 'edit', 'delete'],
					                 'manager' => ['show', 'edit']
				                 ]);
		} 
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		foreach (\CMS::coreModuleParts()->getModuleParts('menus') as $modulePart) 
		{
			\CMS::deleteItemPermissions($modulePart->part_key);
		}
	}
}