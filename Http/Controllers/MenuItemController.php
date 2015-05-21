<?php namespace App\Modules\Menus\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Menus\Http\Requests\MenuItemFormRequest;
use App\Modules\Menus\Repositories\MenuRepository;

class MenuItemController extends Controller {

	private $menu;
	protected $permissions=['getPublish' => 'edit', 'getUnpublish' => 'edit', 'getShow' => 'show'];

	public function __construct(MenuRepository $menu)
	{
		$this->menu = $menu;
	}

	public function getShow($menu_slug)
	{	
		$menus     = $this->menu->getAllMenus();
		$menuItems = $this->menu->getAllMenuItems($menu_slug);

		return view('menus::menuitems.menuitems', compact('menuItems', 'menu_slug'));
	}

	public function getCreate($menu_slug)
	{
		$links     = $this->menu->getLinks();
		$menus     = $this->menu->getAllMenus();
		$menuItems = $this->menu->getAllMenuItems($menu_slug);
		return view('menus::menuitems.createmenuitems', compact('menus', 'menuItems', 'links'));
	}

	public function postCreate(MenuItemFormRequest $request)
	{
		$data['user_id'] = \Auth::user()->id;
		if ($request->link == "") 
		{
			$data['link'] = "#";
			$this->menu->createMenuItem(array_merge($request->except('user_id', 'link'), $data));
			return redirect()->back()->
			with('message', 'Menu successfully created');
		}
		
		$this->menu->createMenuItem(array_merge($request->except('user_id'), $data));
		return redirect()->back()->
		with('message', 'Menu successfully created');
	}

	public function getEdit($id, $menu_slug)
	{
		$links     = $this->menu->getLinks();
		$menuitem  = $this->menu->getMenuItem($id);
		$menus     = $this->menu->getAllMenus();
		$menuItems = $this->menu->getAllMenuItems($menu_slug);

		return view('menus::menuitems.editmenuitem', compact('menuitem', 'menus', 'menuItems', 'links'));
	}

	public function postEdit(MenuItemFormRequest $request, $id)
	{
		if ($request->link == "") 
		{
			$data['link'] = "#";
			$this->menu->updateMenuItem($id, array_merge($request->except('user_id', 'link'), $data));
			return redirect('admin/menus')->
			with('message', 'Menu successfully updated');
		}
		$this->menu->updateMenuItem($id, array_merge($request->all()));
		return redirect('admin/menus')->
		with('message', 'Menu successfully updated');
	}
	
	public function getDelete($id)
	{
		$this->menu->deleteMenuItem($id);
		return redirect()->back()->with('message', 'Menu Deleted succssefully');
	}

	public function getPublish($id)
	{
		$this->menu->publishMenuItem($id);
		return redirect()->back();
	}

	public function getUnpublish($id)
	{
		$this->menu->unpublishMenuItem($id);
		return redirect()->back();
	}
	
}