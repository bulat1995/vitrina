<style>
.rating-area {
	overflow: hidden;
	width: 215px;
    float:left;
}
.rating-area:not(:checked) > input {
	display: none;
}
.rating-area:not(:checked) > label {
	float: right;
	width: 42px;
	padding: 0;
	cursor: pointer;
	font-size: 32px;
	line-height: 32px;
	color: lightgrey;
	text-shadow: 1px 1px #bbb;
}
.rating-area:not(:checked) > label:before {
	content: '★';
}
.rating-area > input:checked ~ label {
	color: gold;
	text-shadow: 1px 1px #c60;
}
.rating-area:not(:checked) > label:hover,
.rating-area:not(:checked) > label:hover ~ label {
	color: gold;
}
.rating-area > input:checked + label:hover,
.rating-area > input:checked + label:hover ~ label,
.rating-area > input:checked ~ label:hover,
.rating-area > input:checked ~ label:hover ~ label,
.rating-area > label:hover ~ input:checked ~ label {
	color: gold;
	text-shadow: 1px 1px goldenrod;
}
.rate-area > label:active {
	position: relative;
}
</style>
    	<div class="contact_form">
    		<div class="container">
    			<div class="row">
    				<div class="col-lg-10 offset-lg-1">
    					<div class="contact_form_container">
							@if($review->exists)
								<div class="contact_form_title">{{__('edit review')}}</div>
							@else
	    						<div class="contact_form_title">{{__('new review')}}</div>
							@endif
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger">{{ $error }}</div>
                                @endforeach
                            @endif
							@if($review->exists)
								<form action="{{ route('shop.reviews.update',$review->id) }}" id="contact_form" method="post">
									@method('PATCH')
							@else
								<form action="{{ route('shop.reviews.store') }}" id="contact_form" method="post">
							@endif
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
    							<div class="contact_form_text">
    								<textarea id="contact_form_message" class="text_field contact_form_message" name="review" rows="4" placeholder="{{ __('review') }}" required="required" data-error="Please, write us a message.">{{ old('review',$review->review) }}</textarea>
    							</div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="rating-area">
                                            <input type="hidden" name="estimate" value="1">
                                            <input type="radio" id="star-5" name="estimate" value="5" @if(!empty($review->estimate)) @if($review->estimate==5) checked="checked" @endif @endif>
                                            <label for="star-5" title="«5»"></label>
                                            <input type="radio" id="star-4" name="estimate" value="4" @if(!empty($review->estimate)) @if($review->estimate==4) checked="checked" @endif @endif>
                                            <label for="star-4" title="«4»"></label>
                                            <input type="radio" id="star-3" name="estimate" value="3" @if(!empty($review->estimate)) @if($review->estimate==3) checked="checked" @endif @endif>
                                            <label for="star-3" title="«3»"></label>
                                            <input type="radio" id="star-2" name="estimate" value="2" @if(!empty($review->estimate)) @if($review->estimate==2) checked="checked" @endif @endif>
                                            <label for="star-2" title="«2»"></label>
                                            <input type="radio" id="star-1" name="estimate" value="1" @if(!empty($review->estimate)) @if($review->estimate==1) checked="checked" @endif @endif>
                                            <label for="star-1" title="«1»"></label>
                                        </div>
										@if($review->exists)
											<button type="submit" class="button contact_submit_button mt-0 float-right">{{ __('edit') }}</button>
										@else
											<button type="submit" class="button contact_submit_button mt-0 float-right">{{ __('send') }}</button>
										@endif
                                    </div>
    						</form>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>

    	<!-- Map -->
