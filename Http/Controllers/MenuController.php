<?php namespace App\Modules\Menus\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Menus\Http\Requests\MenuFormRequest;
use App\Modules\Menus\Repositories\MenuRepository;

class MenuController extends Controller {

	private $menu;
	protected $permissions=['getActivate' => 'edit', 'getDeactivate' => 'edit'];

	public function __construct(MenuRepository $menu)
	{
		$this->menu = $menu;
	}

	public function getIndex()
	{
		$menus = $this->menu->getAllMenus();
		return view('menus::menus.menu', compact('menus'));
	}

	public function getCreate()
	{
		return view('menus::menus.createmenu');
	}

	public function postCreate(MenuFormRequest $request)
	{
		$this->menu->createMenu($request->all());
		return redirect()->back()->with('message', 'Menu successfully created');
	}

	public function getEdit($id)
	{
		$menu = $this->menu->getMenu($id);
		return view('menus::menus.editmenu', compact('menu'));
	}

	public function postEdit(MenuFormRequest $request, $id)
	{
		$this->menu->updateMenu($id, array_merge($request->all()));
		return redirect('admin/menus');
	}

	public function getDelete($id)
	{
		$this->menu->deleteMenu($id);
		return redirect()->back()->with('message', 'Menu Deleted succssefully');
	}

	public function getActivate($id)
	{
		$this->menu->activateMenu($id);
		return redirect()->back();
	}

	public function getDeactivate($id)
	{
		$this->menu->deactivateMenu($id);
		return redirect()->back();
	}
}