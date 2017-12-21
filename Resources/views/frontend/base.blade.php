@if(!empty($ibanners))

	<?php
		$rnd = str_random('4');
	?>

	<div class="ibanner ibanner-cat">

	@foreach($ibanners as $banner)

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
					<img src="{{URL($banner->options->mainimage)}}" alt="{{ $banner->title }}" class="center-block img-responsive">
				</a>
			</div>
		@else
			<div class="ibanner-code">
				{!! $banner->code !!}
			</div>
		@endif

	@endforeach

	</div> <!--fin de banners-->

@endif