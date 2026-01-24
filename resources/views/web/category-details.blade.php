@extends('web.web-layout')

@section('header')
<!-- SPECIFIC CSS -->
<link href="{{ asset('assets/web/css/listing.css') }}" rel="stylesheet">
@endsection

@section('main')
<div class="page_header element_to_stick mt-6">
	<div class="container">
		<div class="row">
			<div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
				<h1>{{ $totalItems }} total items</h1>
				<a href="#0">Change address</a>
			</div>
			<div class="col-xl-4 col-lg-5 col-md-5">
				<div class="search_bar_list">
					<input type="text" class="form-control" placeholder="Dishes, restaurants or cuisines">
					<button type="submit"><i class="icon_search"></i></button>
				</div>
			</div>
		</div>
		<!-- /row -->		       
	</div>
</div>
<!-- /page_header -->

<div class="container margin_30_20">			
	<div class="row">
		<aside class="col-lg-3" id="sidebar_fixed">
			<div class="type_delivery">
				<ul class="clearfix">
					<li>
						<label class="container_radio">Delivery
							<input type="radio" name="type_d" checked="checked">
							<span class="checkmark"></span>
						</label>
					</li>
					<li>
						<label class="container_radio">Take away
							<input type="radio" name="type_d">
							<span class="checkmark"></span>
						</label>
					</li>
				</ul>
			</div>
			<!-- /type_delivery -->

			<a href="#0" class="open_filters btn_filters"><i class="icon_adjust-vert"></i><span>Filters</span></a>
		
			<div class="filter_col">
				<div class="inner_bt clearfix">Filters<a href="#" class="open_filters"><i class="icon_close"></i></a></div>
				<div class="filter_type">
					<h4><a href="#filter_1" data-bs-toggle="collapse" class="opened">Sort</a></h4>
					<div class="collapse show" id="filter_1">
						<ul>
							<li>
								<label class="container_radio">Top Rated
									<input type="radio" name="filter_sort" checked="">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_radio">Reccomended
									<input type="radio" name="filter_sort">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_radio">Price: low to high
									<input type="radio" name="filter_sort">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_radio">Up to 15% off
									<input type="radio" name="filter_sort">
									<span class="checkmark"></span>
								</label>
							</li>
							 <li>
								<label class="container_radio">All Offers
									<input type="radio" name="filter_sort">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_radio">Distance
									<input type="radio" name="filter_sort">
									<span class="checkmark"></span>
								</label>
							</li>
						</ul>
					</div>
				</div>
				<!-- /filter_type -->
				<div class="filter_type">
					<h4><a href="#filter_2" data-bs-toggle="collapse" class="closed">Categories</a></h4>
					<div class="collapse" id="filter_2">
						<ul>
							<li>
								<label class="container_check">Pizza - Italian <small>12</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_check">Japanese - Sushi <small>24</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_check">Burghers <small>23</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_check">Vegetarian <small>11</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_check">Bakery <small>18</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_check">Chinese <small>12</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_check">Mexican <small>15</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
						</ul>
					</div>
				</div>
				<!-- /filter_type -->
				<div class="filter_type">
					<h4><a href="#filter_3" data-bs-toggle="collapse" class="closed">Distance</a></h4>
					<div class="collapse" id="filter_3">
						<div class="distance"> Radius around selected destination <span></span> km</div>
						<div class="add_bottom_25"><input type="range" min="10" max="50" step="5" value="20" data-orientation="horizontal"></div>
					</div>
				</div>
				<!-- /filter_type -->
				<div class="filter_type last">
					<h4><a href="#filter_4" data-bs-toggle="collapse" class="closed">Rating</a></h4>
					<div class="collapse" id="filter_4">
						<ul>
							<li>
								<label class="container_check">Superb 9+ <small>06</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_check">Very Good 8+ <small>12</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_check">Good 7+ <small>17</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
							<li>
								<label class="container_check">Pleasant 6+ <small>43</small>
									<input type="checkbox">
									<span class="checkmark"></span>
								</label>
							</li>
						</ul>
					</div>
				</div>
				<!-- /filter_type -->
				<p><a href="#0" class="btn_1 outline full-width">Filter</a></p>
			</div>
		</aside>

		<div class="col-lg-9">
			<x-web.top-categories :categories="$categories"/>

			<div class="promo">
				<h3>Free Delivery for your first 14 days!</h3>
				<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.</p>
				<i class="icon-food_icon_delivery"></i>
			</div>
			<!-- /promo -->
			
			<div class="row" id="menuItemsContainer">
				<div class="col-12"><h2 class="title_small">Top Rated</h2></div>
				@foreach ($menuItems as $menuItem)
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
					<div class="strip">
						<figure>
							<span class="ribbon off">15% off</span>
							<img src="{{ asset('assets/web/img/lazy-placeholder.png') }}" data-src="
							@if ($menuItem->images->count() > 0)
								{{ asset('storage/' . $menuItem->images->first()->image_path) }}
							@else
								{{ asset('assets/web/img/lazy-placeholder.png') }}
							@endif" class="img-fluid lazy" alt="">
							<a href="detail-restaurant.html" class="strip_info">
								<small>{{ $menuItem->category->name }}</small>
								<div class="item_title">
									<h3>{{ $menuItem->name }}</h3>
									<small>{{ $menuItem->description }}</small>
								</div>
							</a>
						</figure>
						<ul>
							<li><span class="take yes">Takeaway</span> <span class="deliv yes">Delivery</span></li>
							<li>
								<div class="score"><strong>8.9</strong></div>
							</li>
						</ul>
					</div>
				</div>
				<!-- /strip grid -->
				@endforeach
				
				<div class="col-12 text-center mt-4" id="loadMoreTrigger">
					<div id="loadingSpinner" class="spinner-border text-primary" style="display:none;" role="status">
						{{-- <span class="sr-only">Loading...</span> --}}
					</div>

					{{-- <div id="noMoreItems" class="d-none">
						<p class="text-muted">No more items to load</p>
					</div> --}}
				</div>

			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /col -->
</div>		

<!-- /container -->
@endsection

@section('elements')
@endsection

@section('custom-js')
<!-- SPECIFIC SCRIPTS -->
<script src="{{ asset('assets/web/js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('assets/web/js/specific_listing.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const menuItemsContainer = document.getElementById('menuItemsContainer');
    const loadingSpinner = document.getElementById('loadingSpinner');
    // const noMoreItems = document.getElementById('noMoreItems');
    const loadMoreTrigger = document.getElementById('loadMoreTrigger');

    let offset = 12;
    let limit = 12;
    let isLoading = false;
    let hasMore = {{ $totalItems > 12 ? 'true' : 'false' }};
    const categoryId = {{ $categoryId ?? 'null' }};

    if (!categoryId || !hasMore) return;

    function loadMoreItems() {
        if (isLoading || !hasMore) return;

        isLoading = true;
        loadingSpinner.style.display = 'inline-block';

        fetch(`/api/category/load-more?category_id=${categoryId}&offset=${offset}&limit=${limit}`)
            .then(res => res.json())
            .then(data => {
                if (!data.success || data.items.length === 0) {
                    hasMore = false;
                    // noMoreItems.classList.remove('d-none');
                    observer.disconnect();
                    return;
                }

                let html = '';

                data.items.forEach(item => {
                    const imageUrl = item.images?.length
                        ? `/storage/${item.images[0].image_path}`
                        : '/assets/web/img/lazy-placeholder.png';

                    html += `
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="strip">
                                <figure>
                                    <span class="ribbon off">15% off</span>
                                    <img src="/assets/web/img/lazy-placeholder.png"
                                         data-src="${imageUrl}"
                                         class="img-fluid lazy" alt="">
                                    <a href="/restaurant/${item.slug}" class="strip_info">
                                        <small>${item.category_name ?? ''}</small>
                                        <div class="item_title">
                                            <h3>${item.name}</h3>
                                            <small>${item.description ?? ''}</small>
                                        </div>
                                    </a>
                                </figure>
                                <ul>
                                    <li>
                                        <span class="take yes">Takeaway</span>
                                        <span class="deliv yes">Delivery</span>
                                    </li>
                                    <li><div class="score"><strong>8.9</strong></div></li>
                                </ul>
                            </div>
                        </div>
                    `;
                });

                loadMoreTrigger.insertAdjacentHTML('beforebegin', html);
                offset += data.items.length;
				console.info(offset);
				console.log(data);

				if (!data.hasMore) {
                    hasMore = false;
                    // noMoreItems.classList.remove('d-none');
                    observer.disconnect();
                }

                if (window.lazyLoadInstance) {
                    lazyLoadInstance.update();
                }
            })
            .catch(err => console.error(err))
            .finally(() => {
                isLoading = false;
                loadingSpinner.style.display = 'none';
            });
    }

    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            loadMoreItems();
        }
    }, {
        root: null,
        rootMargin: '150px',
        threshold: 0
    });

    observer.observe(loadMoreTrigger);
});
</script>

@endsection
<!-- Map -->
{{-- <script src="js/main_map_scripts.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initMap"></script> --}}