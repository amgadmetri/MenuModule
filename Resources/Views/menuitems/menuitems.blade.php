@extends('app')
@section('content')

<div class="container">
	<div class="col-sm-9">

    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if (Session::has('message'))
    <div class="alert alert-success">
      <ul>
        <li>{{ Session::get('message') }}</li>
      </ul>
    </div>
    @endif

    <div class="container">
      <div class="col-sm-9">
        @include('menus::parts.menutemplate', ['menuSlug' => $menu_slug])
        <a class="btn btn-default" href='{{ url("admin/menus/menuitem/create", $menu_slug) }}' role="button">Add new menu items</a>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Published</th>
              <th>Menu</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
           @foreach ($menuItems as $menuItem)
           <tr>
            <th scope="row">{{ $menuItem->id }}</th>
            <td>{{ $menuItem->title }}</td>
            <td>{{ $menuItem->status }}</td>
            <td>{{ $menuItem->menu->title}}</td>
            <td>
              <a class="btn btn-default" href='{{ url("admin/menus/menuitem/edit/$menuItem->id", $menu_slug) }}' role="button">Edit</a>
              <a class="btn btn-default" href='{{ url("admin/menus/menuitem/delete/$menuItem->id") }}' role="button">Delete</a>
              @if($menuItem->status == 'unpublished')
              <a class="btn btn-default" href='{{ url("admin/menus/menuitem/publish/$menuItem->id") }}' role="button">Publish</a>
              @else
              <a class="btn btn-default active" href='{{ url("admin/menus/menuitem/unpublish/$menuItem->id") }}' role="button">Unpublish</a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>  
</div>
@stop

