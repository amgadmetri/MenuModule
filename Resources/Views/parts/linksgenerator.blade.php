<div class="form-group">
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach($links as $module => $modulePartMenuItems)
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading{{ $module }}">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#{{ $module }}" aria-expanded="false" aria-controls="{{ $module }}">
              {{ $module }}
            </a>
          </h4>
        </div>
        <div id="{{ $module }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $module }}">
          <div class="panel-body">
            <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">
              @foreach($modulePartMenuItems as $modulePart => $modulePartMenuItem)
                <div class="panel panel-default">
                  <div class="panel-heading" role="tab" id="heading{{ $modulePart }}">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordion2" href="#{{ $modulePart }}" aria-expanded="false" aria-controls="{{ $modulePart }}">
                        {{ $modulePart }}
                      </a>
                    </h4>
                  </div>
                  <div id="{{ $modulePart }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $modulePart }}">
                    <div class="panel-body">
                      <p>All {{ $modulePart }} : </p>
                      <div class="list-group">
                        <div class="link_data_content">
                          @include('menus::parts.linkdata')
                        </div>
                      </div>                     
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@include('menus::parts.assets.paginationlinkdataajaxhandler')
