<?php namespace App\Modules\Menus;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {

	/**
	 * Spescify the storage table.
	 * 
	 * @var table
	 */
	protected $table    = 'menu_items';

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['menu_id', 'title', 'link', 'status', 'parent_id', 'target', 'display_order', 'user_id'];
	
	/**
	 * Get the menuItem menu.
	 * 
	 * @return object
	 */
	public function menu()
	{
		return $this->belongsTo('App\Modules\Menus\Menu');
	}

	/**
	 * Get the menuItem childs.
	 * 
	 * @return collection
	 */
	public function childes()
	{
		return $this->hasMany('App\Modules\Menus\MenuItem', 'parent_id');
	}
	
	public static function boot()
	{
		parent::boot();

		/**
		 * Remove the childes related to 
		 * the deleted menuItems.
		 */
		MenuItem::deleting(function($menuItem)
		{
			$menuItem->childes()->delete();
		});
	}
}
