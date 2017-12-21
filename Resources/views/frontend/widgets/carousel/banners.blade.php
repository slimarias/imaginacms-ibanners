@if(!empty($ibanners))

<?php $rnd = str_random('4'); ?>

<?php $item=1; ?>

<div id="ibanner-carousel-cat-{{$id_cat}}" class="carousel slide" data-ride="carousel">
  

  <div class="carousel-inner" role="listbox">
  <div class="item active ">
  <?php $cont=1; $total=count($ibanners);?>
  @foreach($ibanners as $index=>$banner)


      @if(isset($banner->options->videofile))
        <div class="ibanner-img">
          <a href="{{$banner->url}}" target="_top">
            <video muted autoplay loop id="ban_vf_{{$rnd}}_{{$banner->id}}">
              <source src="{{url($banner->options->videofile)}}" type="video/mp4" />
            </video>
          </a>

        @push('scripts')

          <script>
              jQuery(document).ready(function($) {
                  document.getElementById('ban_vf_{{$rnd}}_{{$banner->id}}').play();
              });

          </script>

        @endpush

        </div>
      @elseif(isset($banner->options->mainimage))

        <div class="ibanner-img">
          <a href="{{$banner->url}}" target="_blank">
            <img src="{{URL($banner->options->mainimage)}}" alt="{{ $banner->title }}" class="img-responsive center-block">
          </a>
        </div>
      @else
        <div class="ibanner-code">
          {!! $banner->code !!}
        </div>
      @endif
     
      @if($cont%($item)==0 && $total>$cont)
          </div>
          <div class="item">
      @endif

    <?php $cont++?>
  @endforeach
    </div>

  </div>

  <a class="left carousel-control" href="#ibanner-carousel-cat-{{$id_cat}}" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#ibanner-carousel-cat-{{$id_cat}}" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

</div>

@endif