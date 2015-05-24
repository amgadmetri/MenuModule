<?php namespace App\Modules\Menus\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Menus\Http\Requests\MenuItemFormRequest;

class MenuItemController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getPublish'   => 'edit', 
	'getUnpublish' => 'edit' , 
	'getShow'      => 'show'
	];

	/**
	 * Create new MenuItemController instance.
	 */
	public function __construct()
	{
		parent::__construct('MenuItems');
	}

	/**
 	 * Display a listing of the menu items.
 	 * 
 	 * @param  string $menuSlug
 	 * @return response
 	 */
	public function getShow($menuSlug)
	{	
		$menus     = \CMS::menuItems()->all();
		$menuItems = \CMS::menus()->getMenuItems($menuSlug);

		return view('menus::menuitems.menuitems', compact('menuItems', 'menuSlug'));
	}

	/**
	 * Show the form for creating a new menu item.
	 * 
 	 * @param  string $menuSlug
	 * @return Response
	 */
	public function getCreate($menuSlug)
	{
		$links     = \CMS::menu()->getLinks();
		$menuItems = \CMS::menu()->getMenuItems($menuSlug);
		$menus     = \CMS::menu()->findBy('menu_slug', $menuSlug);

		return view('menus::menuitems.createmenuitems', compact('menus', 'menuItems', 'links'));
	}

	/**
	 * Store a newly created menu item in menu item.
	 * 
	 * @param  MenuItemFormRequest  $request
	 * @return Response
	 */
	public function postCreate(MenuItemFormRequest $request)
	{
		$data['user_id'] = \Auth::user()->id;
		$data['link']    = strlen(trim($request->link)) ?: "#";		
		\CMS::menuItems()->create(array_merge($request->except('user_id', 'link'), $data));

		return redirect()->back()->with('message', 'Menu Item successfully created');
	}

	/**
	 * Show the form for editing the specified menu item.
	 * 
	 * @param  integer $id
 	 * @param  string  $menuSlug
	 * @return Response
	 */
	public function getEdit($id, $menuSlug)
	{
		$links     = \CMS::menu()->getLinks();
		$menus     = \CMS::menu()->findBy('menu_slug', $menuSlug);
		$menuItems = \CMS::menu()->getMenuItems($menuSlug);
		$menuitem  = \CMS::menuItems()->find($id);

		return view('menus::menuitems.editmenuitem', compact('menuitem', 'menus', 'menuItems', 'links'));
	}

	/**
	 * Update the specified menu item in storage.
	 * 
	 * @param  integer              $id
	 * @param  MenuItemFormRequest  $request
	 * @return Response
	 */
	public function postEdit(MenuItemFormRequest $request, $id)
	{
		$data['link']    = strlen(trim($request->link)) ?: "#";		
		\CMS::menuItems()->update($id, array_merge($request->except('link'), $data));

		return redirect()->back()->with('message', 'Menu Item successfully updated');
	}
	
	/**
	 * Remove the specified menu item from storage.
	 * 
	 * @param  integer  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		\CMS::menuItems()->delete($id);
		return redirect()->back()->with('message', 'Menu Item Deleted succssefully');
	}

	/**
	 * Publish specified menu item.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getPublish($id)
	{
		\CMS::menuItems()->publishMenuItem($id);
		return redirect()->back();
	}

	/**
	 * Unpublish specified menu item.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getUnpublish($id)
	{
		\CMS::menuItems()->unpublishMenuItem($id);
		return redirect()->back();
	}
	
}