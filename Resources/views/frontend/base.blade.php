@if(!empty($ibanners))

	<div class="ibanner ibanner-cat">

	@foreach($ibanners as $banner)

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

	@endforeach

	</div> <!--fin de banners-->

@endif