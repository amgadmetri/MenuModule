<?php namespace App\Modules\Menus;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {

	protected $table    = 'menu_items';
	protected $fillable = [
	'menu_id',
	'title', 
	'link', 
	'status', 
	'parent_id', 
	'target', 
	'display_order', 
	'user_id'
	];
	
	public function menu()
	{
		return $this->belongsTo('App\Modules\Menus\Menu');
	}

	public function childes()
	{
		return $this->hasMany('App\Modules\Menus\MenuItem', 'parent_id');
	}
	
	public static function boot()
	{
		parent::boot();

		MenuItem::deleting(function($menuItem)
		{
			$menuItem->childes()->delete();
		});
	}
}
