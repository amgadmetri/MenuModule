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
    <h3>Add new Menu items</h3>

    <div class="container" >
      <div class="row">
        <div class="col-sm-7">
          <form method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">

            <div class="form-group">
              <label for="menu_id">Menu:</label>
              <select name='menu_id' class="form-control">
                @foreach($menus as $menu)
                <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="title">Title:</label>
              <input 
              type             ="text" 
              class            ="form-control" 
              name             ="title" 
              value            ="{{  $menuitem->title }}" 
              placeholder      ="Add title here .." 
              aria-describedby ="sizing-addon2"
              >
            </div>

            <div class="form-group">
              <label for="link">Link:</label>

              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input 
                type             ="text" 
                class            ="form-control" 
                name             ="link"
                @if ($menuitem->link ==='#')
                value           ="{{''}}" 
                @else
                value           ="{{ $menuitem->link }}"
                @endif  
                placeholder      ="Add Link here or choos from below .." 
                aria-describedby ="sizing-addon2"
                id               ="link" 
                >
              </div>
            </div>

            @include('menus::parts.linkgenerator')

            <div class="form-group">
              <label for="status">Published:</label>
              <select  name  ="status" class="form-control">
                <option @if($menuitem->status === "published") selected @endif  value ="published">published</option>
                <option @if($menuitem->status === "unpublished") selected @endif  value ="unpublished">unpublished</option>
              </select>
            </div>

            <div class ="form-group">
              <label for ="parent_id">Parent Item:</label>
              <select name='parent_id' class="form-control">
                <option value="0">Menu item root</option>
                @foreach($menuItems as $menuItem)
                @if($menuitem->id == $menuItem->id)
                <option disabled value="{{ $menuItem->id }}">{{ $menuItem->title }}</option>
                @else 
                <option 
                @if($menuitem->parent_id === $menuItem->id)
                selected 
                @endif 
                value="{{ $menuItem->id }}">
                {{ $menuItem->title }}
              </option>
              @endif
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="target">Target:</label>
            <select name="target" class="form-control">
              <option @if($menuitem->target === "_parent") selected @endif  value="_parent">_parent</option>
              <option @if($menuitem->target === "_blank") selected @endif  value="_blank">_blank</option>
              <option @if($menuitem->target === "_top") selected @endif value="_top">_top</option>
              <option @if($menuitem->target === "_self") selected @endif value="_self">_self</option>
            </select> 
          </div>

          <div class="form-group">
            <label for="display_order">Display order:</label>
            <input 
            type             ="text" 
            class            ="form-control" 
            name             ="display_order" 
            value            ="{{ $menuitem->display_order }}" 
            placeholder      ="Add display_order here .." 
            aria-describedby ="sizing-addon2"
            >
          </div>

          <div class="form-group">
          <label for="css_class">CSS class:</label>
            <input 
            type             ="text" 
            class            ="form-control" 
            name             ="css_class" 
            value            ="{{ $menuitem->css_class }}" 
            placeholder      ="Add css class here .." 
            aria-describedby ="sizing-addon2"
            >
          </div>

          <div class="form-group">
          <label for="css_attributes">CSS attributes:</label>
            <input 
            type             ="text" 
            class            ="form-control" 
            name             ="css_attributes" 
            value            ="{{ $menuitem->css_attributes }}" 
            placeholder      ="Add css attributes here .." 
            aria-describedby ="sizing-addon2"
            >
          </div>

          <input name="user_id" type="hidden" value="0">
          <button type="submit" class="btn btn-default">Update Menu Item</button>
        </form>
      </div>
    </div>
  </div>

</div>  
</div>
@include('menus::menuitems.assets.selectlink')
@stop