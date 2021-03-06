@extends('site.app')
@section('title', $product->name)
@push('styles')
<link href="{{ asset('frontend/css/flexslider.css') }}" rel='stylesheet' type='text/css' />
@endpush
@section('content')
    <section class="section-pagetop bg-dark">
        <div class="container clearfix">
            <h2 class="title-page">{{ $product->name }}</h2>
        </div>
    </section>
   <section class="banner-bottom-wthreelayouts py-lg-5 py-3">
		<div class="container">
			<div class="inner-sec-shop pt-lg-4 pt-3">
				<div class="row">
						<div class="col-lg-4 single-right-left ">
							<div class="grid images_3_of_2">
								<div class="flexslider1">
			
									<ul class="slides">
										@foreach ($images as $image)
										<li data-thumb="{{ asset('storage/'.$image->full) }}">
											<div class="thumb-image"> <img src="{{ asset('storage/'.$image->full) }}" data-imagezoom="true" class="img-fluid" alt=" "> </div>
										</li>
										@endforeach
									</ul>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
						<div class="col-lg-8 single-right-left simpleCart_shelfItem">
							<h3>
								{{ $product->name }}
								@if($product->status)
								<br>
								<small style="font-size: 50%; background: #ff4e00; color: #fff; padding: 5px;">Sold out!</small>
								@endif
							</h3>
							<p>
								<span class="item_price">
									{{ config('settings.currency_symbol') }}
									<span class="price_amount">{{ $product->price }}</span>
								</span>
							</p>
							@if(!$product->status)
							<p>
								<span class="item_price">
									<span class="price_amount">In Stock: {{ $product->quantity }}</span>
								</span>
							</p>
							@endif
							<div class="description">
								<h5>{{ $product->description }}</h5>
							
							</div>
							
							@if(!$product->status)
							<div class="color-quality">
								<div class="color-quality-right">
									<h5>Quantity :</h5>
									<input type="number" id="quantity" class="form-control" style="width: 80px;" value="1" max="{{ $product->quantity }}"/>
								</div>
							</div>
							<div class="occasional">
								<h5>Types :</h5>
								@foreach($attributes as $attribute)
									@php $attributeCheck = in_array($attribute->id, $product->attributes->pluck('attribute_id')->toArray()) @endphp
									@if ($attributeCheck)
										<dt>{{ $attribute->name }}: </dt>
										<dd>
											<select class="form-control form-control-sm option attribute" style="width:180px;" name="{{ strtolower($attribute->name ) }}">
												<option data-price="0" value="0"> Select a {{ $attribute->name }}</option>
												@foreach($product->attributes as $attributeValue)
													@if ($attributeValue->attribute_id == $attribute->id)
														<option
															data-price="{{ $attributeValue->price }}" data-id={{ $attributeValue->attribute_id }}
															value="{{ $attributeValue->value }}"> {{ ucwords($attributeValue->value) }}
														</option>
													@endif
												@endforeach
											</select>
										</dd>
									@endif
								@endforeach
							</div>
							<div class="occasion-cart">
								<div class="googles single-item singlepage">
									<form action="#" method="post" class="add-to-cart-form" onsubmit="console.log(event);">
										<input type="hidden" name="cmd" value="_cart">
										<input type="hidden" name="add" value="1">
										<input type="hidden" name="quantity" value="1">
										<input type="hidden" name="googles_item" value="{{ $product->name }}">
										<input type="hidden" name="amount" value="{{ $product->price }}">
										<input type="hidden" name="id" value="{{ $product->id }}">
										<input type="hidden" name="attributes" value="">
										
										<input type="hidden" name="currency_code" value="{{ config('settings.currency_code') }}">
										<button type="submit" class="googles-cart pgoogles-cart">
											Add to Cart
										</button>
									</form>

								</div>
							</div>
							@endif
							
						</div>
						<div class="clearfix"> </div>
						<!--/tabs-->
						
						<!--//tabs-->
				
				</div>
			</div>
		</div>
		@if ($featured)
		<div class="container-fluid">
			<!--/slide-->
			<div class="slider-img mid-sec mt-lg-5 mt-2 px-lg-5 px-3">
				<!--//banner-sec-->
				<h3 class="tittle-w3layouts text-left my-lg-4 my-3">Popular Items</h3>
				<div class="mid-slider">
					<div class="owl-carousel owl-theme row">
						@for ($i = 0; $i < 6; $i++)
							@if ($i >= count($featured))
								@break
							@else
							<div class="item">
								<div class="gd-box-info text-center">
									<div class="product-men women_two bot-gd">
										<div class="product-googles-info slide-img googles">
											<div class="men-pro-item">
												<div class="men-thumb-item">
												@if ($featured[$i]->main == NULL)
													<img src="{{ asset('default/product.png') }}" class="img-fluid" alt="">
												@else
													<img src="{{ asset('storage/'.$featured[$i]->main) }}" class="img-fluid" alt="">
												@endif
													<div class="men-cart-pro">
														<div class="inner-men-cart-pro">
															<a href="{{ $featured[$i]->slug }}" class="link-product-add-cart">Quick View</a>
														</div>
													</div>
													@if ($featured[$i]->status)
													<span class="product-new-top">Soldout</span>
													@endif
												</div>
												<div class="item-info-product">

													<div class="info-product-price">
														<div class="grid_meta">
															<div class="product_price">
																<h4>
																	<a href="{{ $featured[$i]->slug }}">{{ $featured[$i]->name }} </a>
																</h4>
																<div class="grid-price mt-2">
																	<span class="money ">{{ config('settings.currency_symbol') }}{{ $featured[$i]->price }}</span>
																</div>
															</div>
															<ul class="stars">
																<li>
																	<a href="#">
																		<i class="fa fa-star" aria-hidden="true"></i>
																	</a>
																</li>
																<li>
																	<a href="#">
																		<i class="fa fa-star" aria-hidden="true"></i>
																	</a>
																</li>
																<li>
																	<a href="#">
																		<i class="fa fa-star" aria-hidden="true"></i>
																	</a>
																</li>
																<li>
																	<a href="#">
																		<i class="fa fa-star-half-o" aria-hidden="true"></i>
																	</a>
																</li>
																<li>
																	<a href="#">
																		<i class="fa fa-star-o" aria-hidden="true"></i>
																	</a>
																</li>
															</ul>
														</div>
														<div class="googles single-item hvr-outline-out">
															<form action="#" method="post">
																<input type="hidden" name="cmd" value="_cart">
																<input type="hidden" name="add" value="1">
																<input type="hidden" name="googles_item" value="{{ $featured[$i]->name }}">
																<input type="hidden" name="amount" value="{{ $featured[$i]->price }}">
																<input type="hidden" name="id" value="{{ $featured[$i]->id }}">
																<input type="hidden" name="slug" value="{{ $featured[$i]->slug }}">
																<input type="hidden" name="currency_code" value="{{ config('settings.currency_code') }}">
																<button type="submit" class="googles-cart pgoogles-cart">
																	<i class="fas fa-cart-plus"></i>
																</button>

															</form>

														</div>
													</div>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endif
						@endfor
					</div>
				</div>
			</div>
			<!--//slider-->
		</div>
		@endif
	</section>
@stop
@push('scripts')
<!-- FlexSlider -->
	<script src="{{ asset('frontend/js/jquery.flexslider.js') }}"></script>
	<script>
		// Can also be used with $(document).ready()
		$(window).load(function () {
			$('.flexslider1').flexslider({
				animation: "slide",
				controlNav: "thumbnails"
			});
		});
	</script>
	<!-- //FlexSlider-->

    <script>
        $(document).ready(function () {
			let attributes = {};
            $('#addToCart').submit(function (e) {
                if ($('.option').val() == 0) {
                    e.preventDefault();
                    alert('Please select an option');
                }
            });
            $('.option').change(function () {
                $('#productPrice').html("{{ $product->sale_price != '' ? $product->sale_price : $product->price }}");
                let extraPrice = $(this).find(':selected').data('price');
                let price = parseFloat($('#productPrice').html());
                let finalPrice = (Number(extraPrice) + price).toFixed(2);
                $('#finalPrice').val(finalPrice);
                $('#productPrice').html(finalPrice);
			});
			$('#quantity').change(function () {
				document.querySelector('[name="quantity"]').value = $(this).val();
			})

			$('.attribute').change(function () {
				console.log($(this).val() + " = " + $(this).find(':selected').data('price'));
				if ($(this).find(':selected').data('price') == 0){
					$('.price_amount').html({{ $product->price }});
					document.querySelector('[name="amount"]').value = {{ $product->price }};
					document.querySelector('[name="googles_item"]').value = "{{ $product->name }}";
					document.querySelector('[name="attributes"]').value = "";
				} else {
					$('.price_amount').html($(this).find(':selected').data('price'));
					document.querySelector('[name="amount"]').value = $(this).find(':selected').data('price');
					document.querySelector('[name="googles_item"]').value = "{{ $product->name }}: " + $(this).val();
					attributes[$(this).prop('name')] = $(this).val();
					document.querySelector('[name="attributes"]').value = JSON.stringify(attributes);
					console.log(JSON.stringify(attributes))
				}
			});
        });
    </script>
@endpush