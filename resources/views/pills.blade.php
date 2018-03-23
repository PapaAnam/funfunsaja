<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  @foreach ($items as $key => $item)
  <li class="nav-item">
    @if(is_array($item))
    <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="{{ $item[1] }}">{{ $item[0] }}</a>
    @else
    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="pills-{{ $key }}-tab" data-toggle="pill" href="#pills-{{ $key }}" role="tab" aria-controls="pills-{{ $key }}" aria-selected="true">{{ $item }}</a>
    @endif
  </li>
  @endforeach
</ul>