<a class="text-dark" style="text-decoration: none;" href="{{ $a->full_url }}"><h5>{{ $a->title }}</h5></a>
<i class="fa fa-user"></i> <a class="text-dark" href="{{ url('/profile/'.$a->user->username) }}">{{ $a->user->username }}</a>
<i class="fa fa-clock-o"></i> {{ $a->crat }}
<i class="fa fa-tags"></i> 
@foreach(explode(',', $a->tags) as $tag)
@if((!is_null($tag) && trim($tag) != ''))
<a class="text-dark" href="{{ url('/contents/with-tag/'.$tag) }}">{{ $tag }}</a>
@if($loop->iteration < (count(explode(',', $a->tags)) - 1)) ,
@endif
@endif
@endforeach