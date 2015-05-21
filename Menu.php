<?php namespace App\Modules\Menus;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {

	protected $table    = 'menus';
	protected $fillable = ['title', 'menu_slug', 'description', 'is_active'];

	public function menuItems()
	{
		return $this->hasMany('App\Modules\Menus\MenuItem', 'menu_id');
	}
	
	public static function boot()
	{
		parent::boot();

		Menu::deleting(function($menu)
		{
			$menu->menuItems()->delete();
		});
	}
}
