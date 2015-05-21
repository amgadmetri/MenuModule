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
    <h3>Add new Menu</h3>

    <div class="container" >
      <div class="row">
        <div class="col-sm-7">

          <form method="post">
            <input name="_token" type="hidden" value="{{ csrf_token() }}">
            <div class="form-group">
              <label for="title">Title:</label>
              <input 
              type="text" 
              class="form-control" 
              name="title" 
              value="{{ $menu->title }}" 
              placeholder="Add title here .." 
              aria-describedby="sizing-addon2"
              >
            </div>
            <div class="form-group">
              <label for="menu_slug">Menu:</label>
              <input 
              type="text" 
              class="form-control" 
              name="menu_slug" 
              value="{{ $menu->menu_slug }}" 
              placeholder="Add menu here .." 
              aria-describedby="sizing-addon2"
              >
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <input 
              type="text" 
              class="form-control" 
              name="description" 
              value="{{ $menu->description }}" 
              placeholder="Add menu description here .." 
              aria-describedby="sizing-addon2"
              >
            </div>
            <div class="form-group">
             <label for="is_active">Is_active:</label>
             @if( $menu->is_active == 1 )
             <input type="checkbox" name="is_active" value="1" checked><br>
             @else 
             <input type="checkbox" name="is_active" value="0" ><br>
             @endif
           </div>
           <button type="submit" class="btn btn-default">Update Menu</button>
         </form>
       </div>
     </div>
   </div>

 </div>  
</div>
@stop