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
        href  = "{{ $modulePartMenuItem['data']->previousPageUrl() }}" 
        class = "linkDataPrevious"
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
        class = "linkDataNext"
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