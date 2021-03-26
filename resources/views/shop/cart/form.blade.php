@if(!empty($cart))
    <form action="{{ route('shop.cart.destroy',$cart->id) }}" method="POST">
        @csrf
    @method('DELETE')
    <div class="button_container row">
        <div class="col-md-6">
            <div class="product_quantity clearfix">
                <span>{{ __('quantity') }}: </span>
                <input id="quantity_input" type="text" name="quantity" pattern="[0-9]*" value="{{ $cart->quantity }}">
            </div>
        </div>
        <div class="col-md-6">
    		<button type="submit" class="btn btn-lg btn-danger">{{ __('delete from cart') }}</button>
        </div>
	</div>
    </form>
@else
    <form action="{{ route('shop.cart.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif
	<div class="clearfix" style="z-index: 1000;">
		<!-- Product Quantity -->
		<div class="product_quantity clearfix">
			<span>{{ __('quantity') }}: </span>
			<input id="quantity_input" type="text" name="quantity" pattern="[0-9]*" value=1>
			<div class="quantity_buttons">
				<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
				<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
			</div>
		</div>
	</div>

	<div class="button_container">
		<button type="submit" class="button cart_button">{{ __('add to cart') }}</button>
		<div class="product_fav"><i class="fas fa-heart"></i></div>
	</div>
</form>

@endif
