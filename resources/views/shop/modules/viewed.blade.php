<div class="viewed">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="viewed_title_container">
                    <h3 class="viewed_title">{{__('lastViewed')}}</h3>
                    <div class="viewed_nav_container">
                        <div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
                        <div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
                    </div>
                </div>

                <div class="viewed_slider_container">

                    <!-- Recently Viewed Slider -->

                    <div class="owl-carousel owl-theme viewed_slider">

                        <!-- Recently Viewed Item -->
                        @foreach($last_viewed as $last)
                            <div class="owl-item">
                                <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="viewed_image">
                                        @if(!empty($last->photo))
                                        <img src="{{ asset(config('my.product.photo.filePathWeb').$last->photo) }}" alt="">
                                        @else
                                            <img src="{{ asset(config('my.global.path.image_not_available')) }}" alt="">
                                        @endif
                                    </div>
                                    <div class="viewed_content text-center">
                                        <div class="viewed_price">{{ $last->price }} P.</div>
                                        <div class="viewed_name"><a href="#">{{ $last->name }}</a></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
