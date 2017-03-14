@if(!empty($ibanners))

<?php $item=1; ?>

<div id="ibanner-carousel-cat-{{$id_cat}}" class="carousel slide" data-ride="carousel">
  

  <div class="carousel-inner" role="listbox">
  <div class="item active ">
  <?php $cont=1; $total=count($ibanners);?>
  @foreach($ibanners as $index=>$banner)
    

      @if($banner->options)
        <div class="ibanner-img">
          <a href="{{$banner->url}}" target="_blank">
            <img src="{{URL($banner->options->mainimage)}}" alt="{{ $banner->title }}" class="img-responsive">
          </a>
        </div>
      @else
        <div class="ibanner-code">
          {{ $banner->code }}
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