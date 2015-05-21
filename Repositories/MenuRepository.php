<?php namespace App\Modules\Menus\Repositories;

use App\Modules\Menus\Traits\MenuItemTrait;
use App\Modules\Menus\Traits\MenuTrait;
use App\Modules\Menus\Menu;

class MenuRepository
{
	use MenuItemTrait;
	use MenuTrait;

	public function getLinks()
	{
		$links = array();
		foreach (\Module::all() as $module) 
		{
			if (array_key_exists('module_parts_menu', $module)) 
			{
				foreach ($module['module_parts_menu'] as $menuItem) 
				{
					$repository                        = '\\' . ucfirst(str_singular($module['name'])) . 'Repository';
					$repositoryMethod                  = 'getAll' . $menuItem;
					$data                              = $repository::$repositoryMethod();
					$links[$module['name']][$menuItem] = [ 
					'data'      => $data, 
					'base_link' => url('/' . strtolower(str_singular($menuItem))),
					'all_link'  => url('/' . strtolower(str_singular($menuItem)) . 's'),
					'add_link'  => url('/add' . strtolower(str_singular($menuItem)))
					];
				}
			}
		}
		return $links;
	}

	public function getRenderMenu($menuSlug, $parent_id = 0)
	{
		$menuItems = $this->getAllMenuItems($menuSlug);
		$html      = '';
		foreach ($menuItems as $menuItem) 
		{
			if ($menuItem->parent_id == $parent_id) 
			{
				if ($menuItem->status == 'published') 
				{
					$html .= view('menus::parts.menu', compact('menuItem'))->render();
				}

			}

		}
		return $html;
	}


	public function getDisplayMenu($menuSlug)
	{
		return view('menus::parts.menutemplate', ['menuSlug' => $menuSlug])->render();
	}
}
