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
              value            ="{{ old('title') }}" 
              placeholder      ="Add title here .." 
              aria-describedby ="sizing-addon2"
              >
            </div>

            <div class="form-group">
              <label for="link">Link: <i>If you want to "#" it leave it blank </i></label>
              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input 
                type             ="text" 
                class            ="form-control" 
                name             ="link" 
                value            ="{{ old('link') }}" 
                placeholder      ="Add Link here or choose from below .." 
                aria-describedby ="sizing-addon2"
                id               ="link" 
                >
              </div>
            </div>

            @include('menus::parts.linkgenerator')
            <div class="form-group">
              <label for="status">Published:</label>
              <select name="status" class="form-control">
                <option value ="published">published</option>
                <option value ="unpublished">unpublished</option>
              </select>
            </div>

            <div class ="form-group">
              <label for ="parent_id">Parent Item:</label>
              <select name='parent_id' class="form-control">
                <option value ="0">Menu item root</option>
                @foreach($menuItems as $menuItem)
                <option value ="{{ $menuItem->id }}">{{ $menuItem->title }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="target">Target:</label>
              <select name="target" class="form-control">
                <option value="_parent">_parent</option>
                <option value="_blank">_blank</option>
                <option value="_top">_top</option>
                <option value="_self">_self</option>
              </select> 
            </div>

            <div class="form-group">
              <label for="display_order">Display order:</label>
              <input 
              type             ="text" 
              class            ="form-control" 
              name             ="display_order" 
              value            ="{{ old('display_order') }}" 
              placeholder      ="Add display_order here .." 
              aria-describedby ="sizing-addon2"
              >
            </div>

            <button type="submit" class="btn btn-default">Add Menu Items</button>
          </form>
        </div>
      </div>
    </div>
    
  </div>  
</div>
@include('menus::menuitems.assets.selectlink')
@stop