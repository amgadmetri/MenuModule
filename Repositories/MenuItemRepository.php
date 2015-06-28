<?php namespace App\Modules\Menus\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class MenuItemRepository extends AbstractRepository
{
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Menus\MenuItem';
	}
	
	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['menu', 'children'];
	}
	
	/**
	 * Return a specified menu item wit translations.
	 * 
	 * @param  integer $id
	 * @return object
	 */
	public function getMenuItem($id, $language = false)
	{
		$menuItem        =  $this->find($id);
		$menuItem->title = \CMS::languageContents()->getTranslations($menuItem->id, 'menu_item', $language, 'title');

		return $menuItem;
	}

	/**
	 * Store the Menu Item and it's translations in to the storage.
	 * 
	 * @param  array $data 
	 * @return object
	 */
	public function createMenuItem($data)
	{	
		$menuItem = $this->create($data);
		\CMS::languageContents()->insertLanguageContent(['title' => $data['title']], 'menu_item', $menuItem->id);
		
		return $menuItem;
	}

	/**
	 * Store the Menu Item and it's translations in to the storage.
	 * 
	 * @param  array $data 
	 * @return object
	 */
	public function updateMenuItem($id, $data)
	{	
		$this->update($id, $data);
		\CMS::languageContents()->insertLanguageContent(['title' => $data['title']], 'menu_item', $id);

		return $this->find($id);
	}

	/**
	 * Change the status of specific menu to
	 * published.
	 * 
	 * @param  integer $id
	 * @return void
	 */
	public function publishMenuItem($id)
	{
		$this->update($id, ['status' => 'published']);
	}
	
	/**
	 * Change the status of specific menu to
	 * unpublished.
	 * 
	 * @param  integer $id
	 * @return void
	 */
	public function unpublishMenuItem($id)
	{
		$this->update($id, ['status' => 'unpublished']);
	}
}
