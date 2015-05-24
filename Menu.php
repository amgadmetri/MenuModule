<?php namespace App\Modules\Menus;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

	/**
	 * Spescify the storage table.
	 * 
	 * @var table
	 */
	protected $table    = 'menus';

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['title', 'menu_slug', 'description', 'is_active'];

	/**
	 * Get the menu menuItems.
	 * 
	 * @return collection
	 */
	public function menuItems()
	{
		return $this->hasMany('App\Modules\Menus\MenuItem', 'menu_id');
	}
	
	public static function boot()
	{
		parent::boot();

		/**
		 * Remove the menuItems related to 
		 * the deleted menu.
		 */
		Menu::deleting(function($menu)
		{
			$menu->menuItems()->delete();
		});
	}
}
