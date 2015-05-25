@if (\CMS::menus()->checkMenu($menuSlug))
	<div id='custom-bootstrap-menu' class='navbar navbar-default ' role='navigation'>
		<div class='container-fluid'>
			<div class='collapse navbar-collapse navbar-menubuilder'>
				<ul class='nav navbar-nav navbar-left'>
					{!! \CMS::menus()->getMenuTree($menuSlug) !!}
				</ul> 
			</div>
		</div>
	</div>
@endif

