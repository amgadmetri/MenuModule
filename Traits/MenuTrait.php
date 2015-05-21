<?php namespace App\Modules\Menus\Traits;

use App\Modules\Menus\Menu;

trait MenuTrait{

	public function getAllMenus()
	{
		return Menu::all();
	}

	public function getMenu($id)
	{
		return Menu::find($id);
	}
	
	public function createMenu($data)
	{
		return Menu::create($data);
	}

	public function deleteMenu($id)
	{	
		$menu = $this->getMenu($id);
		return $menu->delete();
	}
	
	public function activateMenu($id)
	{
		$menu            = $this->getMenu($id);
		$menu->is_active = 1;
		return $menu->save();
	}
	public function deactivateMenu($id)
	{
		$menu            = $this->getMenu($id);
		$menu->is_active = 0;
		return $menu->save();
	}
	
	public function updateMenu($id, $data)
	{
		$menu = $this->getMenu($id);
		return $menu->update($data);
	}

	public function checkMenu($menuSlug)
	{	
		return Menu::where('menu_slug', '=', $menuSlug)->first()->is_active;
	}
	
}