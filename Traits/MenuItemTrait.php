<?php namespace App\Modules\Menus\Traits;

use App\Modules\Menus\MenuItem;
use App\Modules\Menus\Menu;

trait MenuItemTrait{

	public function getAllMenuItems($menu)
	{
		return Menu::where('menu_slug', '=', $menu)->first()->menuItems()->orderBy('display_order')->get();
	}
	
	public function getMenuItem($id)
	{
		return MenuItem::find($id);
	}

	public function createMenuItem($data)
	{
		return MenuItem::create($data);
	}
	
	public function deleteMenuItem($id)
	{	
		$menu = $this->getMenuItem($id);
		return $menu->delete();
	}

	public function updateMenuItem($id, $data)
	{
		$menu = $this->getMenuItem($id);
		return $menu->update($data);
	}
	
	public function publishMenuItem($id)
	{
		$menu         = $this->getMenuItem($id);
		$menu->status = 'published';
		return $menu->save();
	}
	
	public function unpublishMenuItem($id)
	{
		$menu         = $this->getMenuItem($id);
		$menu->status = 'unpublished';
		return $menu->save();
	}

	
}