<?php namespace App\Modules\Menus\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseController;

class MenuController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getActivate'   => 'change-status', 
	'getDeactivate' => 'change-status' , 
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
		$menus = \CMS::menus()->getAllMenus();
		return view('menus::menus.menu', compact('menus'));
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