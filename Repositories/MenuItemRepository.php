<?php namespace App\Modules\Menus\Repositories;

use App\AbstractRepositories\AbstractRepository;

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
		return ['menu', 'childes'];
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
		\CMS::languageContents()->insertLanguageContent(['title' => $data['title']], 'menu', $menuItem->id);
		
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
		\CMS::languageContents()->insertLanguageContent(['title' => $data['title']], 'menu', $menuItem->id);

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
