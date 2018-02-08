@if(!empty($ibanners))

    <?php
    $rnd = str_random('4');
    ?>

    <div class="ibanner ibanner-cat">

        @foreach($ibanners as $banner)

            @if(isset($banner->options->mediafile)&&!empty($banner->options->mediafile))
                <div class="ibanner-img">
                    @if(strpos($banner->options->mediafile,".mp4"))
                        <a href="{{$banner->url}}" target="_top">
                            <video muted autoplay loop id="ban_vf_{{$rnd}}_{{$banner->id}}">
                                <source src="{{url($banner->options->mediafile)}}" type="video/mp4"/>
                            </video>
                        </a>

                        @push('scripts')
                            <script>
                                jQuery(document).ready(function ($) {
                                    document.getElementById('ban_vf_{{$rnd}}_{{$banner->id}}').play();
                                });

                            </script>

                        @endpush
                    @elseif(strpos($banner->options->mediafile,".webm"))
                        <a href="{{$banner->url}}" target="_top">
                            <video muted autoplay loop id="ban_vf_{{$rnd}}_{{$banner->id}}">
                                <source src="{{url($banner->options->mediafile)}}" type="video/webm"/>
                            </video>
                        </a>

                        @push('scripts')
                            <script>
                                jQuery(document).ready(function ($) {
                                    document.getElementById('ban_vf_{{$rnd}}_{{$banner->id}}').play();
                                });

                            </script>

                        @endpush
                    @else
                        <a href="{{$banner->url}}" target="_blank">
                            <img src="{{url($banner->options->mediafile)}}" alt="{{$banner->title}}" class="center-block img-responsive">
                        </a>
                    @endif

                </div>
            @elseif(isset($banner->options->mainimage) && !empty($banner->options->mainimage))

                <div class="ibanner-img">
                    <a href="{{$banner->url}}" target="_blank">
                        <img src="{{URL($banner->options->mainimage)}}" alt="{{ $banner->title }}"
                             class="center-block img-responsive">
                    </a>
                </div>
            @elseif(isset($banner->code) && !empty($banner->code))
                <div class="ibanner-code">
                    {!!$banner->code!!}
                </div>
            @endif

        @endforeach

    </div> <!--fin de banners-->

@endif