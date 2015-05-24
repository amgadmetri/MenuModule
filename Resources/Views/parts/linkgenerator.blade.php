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
                    <div class="list-group">
                      <a href="{{ $modulePartMenuItem['all_link'] }}" class="selectlink list-group-item">
                        All {{ $modulePart }}
                      </a>
                      <a href="{{ $modulePartMenuItem['add_link'] }}" class="selectlink list-group-item">
                        Add {{ str_singular($modulePart) }}
                      </a>
                      <div class="panel-group" id="accordion3" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion3" href="#{{ $modulePart }}_data" aria-expanded="true" aria-controls="{{ $modulePart }}_data">
                                {{ $modulePart }}
                              </a>
                            </h4>
                          </div>
                          <div id="{{ $modulePart }}_data" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                              <p>All {{ $modulePart }} : </p>
                              <div class="list-group">
                                @foreach($modulePartMenuItem['data'] as $data)
                                <a href="{{ $modulePartMenuItem['base_link'] . '/' . $data->id }}" class="selectlink list-group-item">
                                  {{ $data->link_name }}
                                </a>
                                @endforeach

                                @if($modulePartMenuItem['data'] instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                <nav>
                                  <ul class="pagination">
                                    <li class="previous">
                                      <a 
                                      href = "{{ $modulePartMenuItem['data']->previousPageUrl() }}" 
                                      id   = "commentmodulePrevious"
                                      @if($modulePartMenuItem['data']->previousPageUrl() == null)
                                      class="btn disabled" role="button"
                                      @endif
                                      >
                                      <span aria-hidden="true">&larr;</span> Previous
                                      </a>
                                    </li>

                                    @for($i = 1 ; $i <= $modulePartMenuItem['data']->lastPage() ; $i++)
                                    <li 
                                    @if($modulePartMenuItem['data']->currentPage() == $i)
                                    class="active"
                                    @endif
                                    >
                                    <a 
                                    href ="{{ $modulePartMenuItem['data']->url('admin/', [$i]) }}"
                                    id   ="commentmoduleLinks"
                                    >
                                    {{ $i }}
                                    </a>
                                  </li>
                                  @endfor

                                  <li class="next">
                                    <a 
                                    href = "{{ $modulePartMenuItem['data']->nextPageUrl() }}" 
                                    id   = "commentmoduleNext"
                                    @if($modulePartMenuItem['data']->nextPageUrl() == null)
                                    class="btn disabled" role="button"
                                    @endif
                                    >
                                    Next <span aria-hidden="true">&rarr;</span>
                                    </a>
                                  </li>
                                </ul>
                              </nav>
                              @endif
                            </div>
                          </div>
                        </div>
                      </div>
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
