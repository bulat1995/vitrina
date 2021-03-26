<!-- Reviews -->

<div class="reviews">
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="reviews_title_container">
                    <h3 class="reviews_title">{{__('lastReview')}}</h3>
                    <div class="reviews_all ml-auto"><a href="#"> <span>{{__('allReviews')}}</span></a></div>
                </div>

                <div class="reviews_slider_container">

                    <!-- Reviews Slider -->
                    <div class="owl-carousel owl-theme reviews_slider">

                    @foreach($reviews as $review)
                        <!-- Reviews Slider Item -->
                        <div class="owl-item">
                            <div class="review d-flex flex-row align-items-start justify-content-start">
                                <div><div class="review_image"><img src="/onetech/images/review_1.jpg" alt=""></div></div>
                                <div class="review_content">
                                    <div class="review_name">{{ $review->user_id }}</div>
                                    <div class="review_rating_container">
                                        <div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>
                                        <div class="review_time">{{ $review->date_created }}</div>
                                    </div>
                                    <div class="review_text"><p>{{ $review->review }}</p></div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    </div>
                    <div class="reviews_dots"></div>
                </div>
            </div>
        </div>
    </div>
</div>
