<div class="row">
    <div class="col-md-12">
        <h1 class="text-dark text-center">{{ $our_focus->title }}</h1>
        <h5 class="text-dark text-center">{{ $our_focus->sub_title }}</h5>
    </div>
    @foreach ($our_focus->content as $o)
    <div class="col-md-6 col-sm-6 col-lg-3 animate animated" data-anim-type="bounceInUp">
        <img class="our-focus" src="{{ $o->image_full_url }}">
        <h3 class="text-danger text-center"><strong>{{ $o->caption }}</strong></h3>
    </div>
    @endforeach
</div>
@push('style')
@verbatim
<style>
img.our-focus {
    margin-left: 23%;
    max-width: 200px;
    padding: 10px;
}
@media screen and (max-width: 374px){
    img.our-focus {
        margin-left: 28%;
        max-width: 200px;
        padding: 10px;
    }
}
@media screen and (max-width: 424px) and (min-width: 375px){
    img.our-focus {
        margin-left: 32%;
        max-width: 200px;
        padding: 10px;
    }
}
@media screen and (max-width: 767px) and (min-width: 425px){
    img.our-focus {
        margin-left: 35%;
        max-width: 200px;
        padding: 10px;
    }
}
@media screen and (max-width: 1024px) and (min-width: 768px){
    img.our-focus {
        margin-left: 33%;
        max-width: 200px;
        padding: 10px;
    }
}
</style>
@endverbatim
@endpush