@foreach($modulePartMenuItem['data'] as $data)
  @if($modulePartMenuItem['menuItem'] === 'Page')
    <a href="{{ $modulePartMenuItem['base_link'] . '/' . $data->page_slug }}" class="selectlink list-group-item">
      {{ $data->link_name }}
    </a>
  @else
    <a href="{{ $modulePartMenuItem['base_link'] . '/' . $data->id }}" class="selectlink list-group-item">
      {{ $data->link_name }}
    </a>
  @endif
@endforeach

@if($modulePartMenuItem['data'] instanceof \Illuminate\Pagination\LengthAwarePaginator)
  <nav>
    <ul class="pagination">
      <li class="previous">
        <a 
        href  = "{{ $modulePartMenuItem['data']->previousPageUrl() }}" 
        @if($modulePartMenuItem['data']->previousPageUrl() == null)
          class="linkDataPrevious btn disabled" role="button"
        @else
          class="linkDataPrevious"
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
          href  ="{{ $modulePartMenuItem['data']->url($i) }}"
          class ="linkDataLinks"
          >
          {{ $i }}
          </a>
        </li>
      @endfor

      <li class="next">
        <a 
        href  = "{{ $modulePartMenuItem['data']->nextPageUrl() }}" 
        @if($modulePartMenuItem['data']->nextPageUrl() == null)
          class="linkDataNext btn disabled" role="button"
        @else
          class="linkDataNext"
        @endif
        >
        Next <span aria-hidden="true">&rarr;</span>
        </a>
      </li>
    </ul>
  </nav>
@endif