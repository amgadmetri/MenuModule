<?php namespace App\Modules\Menus\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Menus\Http\Requests\MenuFormRequest;

class MenuController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getActivate'   => 'edit', 
	'getDeactivate' => 'edit' , 
	];

	/**
	 * Create new MenuController instance.
	 */
	public function __construct()
	{
		parent::__construct('Menus');
	}

	/**
 	 * Display a listing of the menus.
 	 * 
 	 * @return response
 	 */
	public function getIndex()
	{
		$menus = \CMS::menus()->all();
		return view('menus::menus.menu', compact('menus'));
	}

	/**
	 * Show the form for creating a new menu.
	 * 
	 * @return Response
	 */
	public function getCreate()
	{
		return view('menus::menus.createmenu');
	}

	/**
	 * Store a newly created menu in menu item.
	 * 
	 * @param  MenuFormRequest  $request
	 * @return Response
	 */
	public function postCreate(MenuFormRequest $request)
	{
		\CMS::menus()->create($request->all());
		return redirect()->back()->with('message', 'Menu successfully created');
	}

	/**
	 * Show the form for editing the specified menu.
	 * 
	 * @param  integer $id
 	 * @param  string  $menu_slug
	 * @return Response
	 */
	public function getEdit($id)
	{
		$menu = \CMS::menus()->find($id);
		return view('menus::menus.editmenu', compact('menu'));
	}

	/**
	 * Update the specified menu in storage.
	 * 
	 * @param  integer          $id
	 * @param  MenuFormRequest  $request
	 * @return Response
	 */
	public function postEdit(MenuFormRequest $request, $id)
	{
		\CMS::menus()->update($id, $request->all());
		return redirect()->back()->with('message', 'Menu successfully updated');
	}

	/**
	 * Remove the specified menu from storage.
	 * 
	 * @param  integer  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		\CMS::menus()->delete($id);
		return redirect()->back()->with('message', 'Menu Deleted succssefully');
	}

	/**
	 * Active specified menu.
	 * 
	 * @param  integer $id
	 * @return response
	 */
	public function getActivate($id)
	{
		\CMS::menus()->activateMenu($id);
		return redirect()->back();
	}

	/**
	 * Deactive specified menu.
	 * 
	 * @param  integer $id
	 * @return response
	 */

	public function getDeactivate($id)
	{
		\CMS::menus()->deactivateMenu($id);
		return redirect()->back();
	}
}