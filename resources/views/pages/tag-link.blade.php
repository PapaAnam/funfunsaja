@foreach(explode(',', $a->tags) as $tag)
@if((!is_null($tag) && trim($tag) != ''))
<a class="text-dark" href="{{ url('/pages/with-tag/'.$tag) }}">{{ $tag }}</a>
@if($loop->iteration < (count(explode(',', $a->tags)) - 1)) ,
@endif
@endif
@endforeach