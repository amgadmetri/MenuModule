<?php namespace App\Modules\Menus\Repositories;

use App\AbstractRepositories\AbstractRepository;

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
	 * Return menu items belongs to specific
	 * menu ordered by display_order.
	 * 
	 * @param  string $menuSlug
	 * @return collection
	 */
	public function getMenuItems($menuSlug)
	{
		return $this->model->where('menu_slug', '=', $menuSlug)->first()->menuItems()->orderBy('display_order')->get();
	}

	/**
	 * Return links to all modules specified menu items
	 * at the module.json file.
	 * 
	 * @return array 
	 */
	public function getLinks($menuSlug)
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
								$data                                      = ! \CMS::$baseType() ? [] : \CMS::$baseType()->getAll($value->link_name, 1);
								$data->setPath(url('admin/menus/menuitem/paginate', [$menuSlug, $value->link_name]));
								$links[$module['name']][$value->link_name] =
								[
								'data'      => $data, 
								'base_link' => url('/' . strtolower(str_singular($value->link_name))),
								'all_link'  => url('/' . strtolower(str_singular($value->link_name)) . 's'),
								'add_link'  => url('/add' . strtolower(str_singular($value->link_name)))
								];
							}
						}
					}
					else
					{
						$data                              = ! \CMS::$menuItem() ? [] : \CMS::$menuItem()->paginate(1);
						$data->setPath(url('admin/menus/menuitem/paginate', [$menuSlug, $menuItem]));
						$links[$module['name']][$menuItem] =
						[
						'data'      => $data, 
						'base_link' => url('/' . strtolower(str_singular($menuItem))),
						'all_link'  => url('/' . strtolower(str_singular($menuItem)) . 's'),
						'add_link'  => url('/add' . strtolower(str_singular($menuItem)))
						];
					}
				}
			}
		}
		return $links;
	}

	/**
	 * Recursive function that build the menu tree.
	 * 
	 * @param  string  $menuSlug
	 * @param  integer $parent_id
	 * @return string
	 */
	public function getMenuTree($menuSlug, $path, $parent_id = 0)
	{
		$path      = $path . '.menu';
		$menuItems = $this->getMenuItems($menuSlug);
		$html      = '';
		foreach ($menuItems as $menuItem) 
		{
			if ($menuItem->parent_id == $parent_id) 
			{
				if ($menuItem->status == 'published') 
				{
					$html .= view($path, compact('menuItem', 'path'))->render();
				}

			}

		}
		return $html;
	}

	/**
	 * Return the menu with the matched menu slug.
	 * Take the path of the template and check if
	 * not exists then construct default directory
	 * if not exists then use the default template.
	 * 
	 * @param  string $menuSlug
	 * @param  string $path
	 * @return string
	 */
	public function renderMenu($menuSlug, $path = false)
	{
		$themename    = \CMS::CoreModules()->getActiveTheme()->module_key ;
		$fullpath     = $themename . "::" . $path;
		$templatename = $themename . "::templates.menutemplates." . $path . ".menutemplate";
		$defaultPath  = 'menus::parts.menutemplate';

		if (view()->exists($fullpath))
		{
			$path = substr($fullpath, 0, strripos($fullpath, "."));
			return view($fullpath, ['menuSlug' => $menuSlug, 'path' => $path])->render();
		}
		elseif (view()->exists($templatename)) 
		{
			$path = substr($templatename, 0, strripos($templatename, "."));
			return view($templatename, ['menuSlug' => $menuSlug, 'path' => $path])->render();
		}
		else
		{
			$path = substr($defaultPath, 0, strripos($defaultPath, "."));
			return view($defaultPath, ['menuSlug' => $menuSlug, 'path' => $path])->render();
		}
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
