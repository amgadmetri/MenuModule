<?php namespace App\Modules\Menus\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class MenuRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Menus\Menu';
	}
	
	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['menuItems'];
	}
	
	/**
	 * Get all menus based on the given theme.
	 * If the theme isn't given then get the default
	 * theme.
	 * 
	 * @param  string $theme
	 * @return collection
	 */
	public function getAllMenus($theme = false)
	{	
		$theme = $theme ?: \CMS::coreModules()->getActiveTheme()->module_key;
		return $this->findBy('theme', $theme);
	}

	/**
	 * Return menu items belongs to specific
	 * menu ordered by display_order.
	 * 
	 * @param  string $menuSlug
	 * @param  string $status
	 * @param  string $language
	 * @return collection
	 */
	public function getMenuItems($menuSlug, $status = 'published', $language = false)
	{
		if ($status == 'all') 
		{
			$menuItems = $this->first('menu_slug', $menuSlug)->menuItems()->orderBy('display_order')->get();
		}
		else
		{
			$menuItems = $this->first('menu_slug', $menuSlug)->menuItems()->
						    	where('status' ,$status)->orderBy('display_order')->get();
		}
		return $this->getMenuTranslations($menuItems, $language);
	}

	/**
	 * Return the menu items and it's children translated data 
	 * based on the given language.
	 * 
	 * @param  collection $menuItems
	 * @param  string     $language
	 * @return collection
	 */
	public function getMenuTranslations($menuItems, $language)
	{
		foreach ($menuItems as $menuItem) 
		{
			$menuItem->title    = \CMS::languageContents()->getTranslations($menuItem->id, 'menu_item', $language, 'title');
			$menuItem->children = $this->getMenuTranslations($menuItem->children, $language);
		}
		return $menuItems;
	}

	/**
	 * Return links to all modules specified menu items
	 * at the module.json file.
	 * 
	 * @return array 
	 */
	public function getLinks()
	{
		$links = array();
		foreach (\Module::all() as $module) 
		{
			if (array_key_exists('module_parts_menu', $module)) 
			{
				foreach ($module['module_parts_menu'] as $menuItem) 
				{
					/**
					 * If array then it is a base type.
					 * Get all sub types and generate
					 * links for them.
					 */
					if (is_array($menuItem)) 
					{
						$baseType = key($menuItem);
						$data     = ! \CMS::$baseType() ? [] : \CMS::$baseType()->all();
						foreach ($data as $key => $value)
						{
							if (method_exists(\CMS::$baseType(), 'getAll'))
							{
								$data = ! \CMS::$baseType() ? [] : \CMS::$baseType()->getAll($value->link_name, 5);
								$data->setPath(url('admin/menus/menuitem/paginate', [$value->link_name]));
								$links[$module['name']][studly_case($value->link_name)] =
								[
								'menuItem'  => current($menuItem), 
								'data'      => $data, 
								'base_link' => url('/' . strtolower(str_singular(current($menuItem))) . '/' .strtolower(snake_case(str_replace (" ", "", $value->link_name)))),
								];
							}
						}
					}
					else
					{
						$data = ! \CMS::$menuItem() ? [] : \CMS::$menuItem()->paginate(5);
						$data->setPath(url('admin/menus/menuitem/paginate', [$menuItem]));
						if ($menuItem == 'Page') 
						{
							$links[$module['name']][$menuItem] =
							[
							'menuItem'  => $menuItem, 
							'data'      => $data, 
							'base_link' => url('/')
							];
						}
						else
						{
							$links[$module['name']][$menuItem] =
							[
							'menuItem'  => $menuItem, 
							'data'      => $data, 
							'base_link' => url('/' . strtolower(str_singular($menuItem)))
							];
						}
					}
				}
			}
		}
		return $links;
	}

	/**
	 * Return the menu based on the given menu type 
	 * and language.
	 * 
	 * @param  string $menuSlug
	 * @param  string $language
	 * @param  string $path
	 * @return string
	 */
	public function renderMenu($menuSlug, $language = false, $path = false)
	{
		if ($this->checkMenu($menuSlug))
		{
			$menu          = $this->first('menu_slug', $menuSlug);
			$menuItems     = $this->getMenuItems($menuSlug, 'published', $language);
			$themeName     = \CMS::CoreModules()->getActiveTheme()->module_key ;
			$specifiedPath = $themeName . "::" . $path . "." . $menu->template;
			$defaultPath   = $themeName . "::templates.menus." . $menu->template;
			
			if ($path && view()->exists($specifiedPath))
			{
				return view($specifiedPath, compact('menuItems'))->render();
			}
			elseif(view()->exists($defaultPath))
			{
				return view($defaultPath, compact('menuItems'))->render();
			}
		}
		return '';
	}

	/**
	 * Change the active of specific menu to
	 * true.
	 * 
	 * @param  integer $id
	 * @return void
	 */
	public function activateMenu($id)
	{
		$this->update($id, ['is_active' => 1]);
	}

	/**
	 * Change the active of specific menu to
	 * false.
	 * 
	 * @param  integer $id
	 * @return void
	 */
	public function deactivateMenu($id)
	{
		$this->update($id, ['is_active' => 0]);
	}

	/**
	 * Check if the menu with the given menu slug
	 * is active or not.
	 * 
	 * @param  string $menuSlug
	 * @return boolean
	 */
	public function checkMenu($menuSlug)
	{	
		$menu = $this->model->where('menu_slug', '=', $menuSlug)->first();
		return $menu ? $menu->is_active : false;
	}
}
