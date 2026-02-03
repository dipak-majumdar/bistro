<div class="row">
    <div class="col-12">
        <h2 class="title_small">Top Categories</h2>
        <div class="owl-carousel owl-theme categories_carousel_in listing">
            @foreach ($categories as $category)
            <div class="item">
                <figure>
                    <img src="{{ asset('assets/web/img/cat_listing_placeholder.png') }}" data-src="{{ asset('storage/' . $category->image) ?? asset('assets/web/img/cat_listing_placeholder.png') }}" alt="" class="owl-lazy"></a>
                    <a href="{{ route('category-details', $category->slug) }}"><h3>{{ $category->name }}</h3></a>
                </figure>
            </div>
            @endforeach
        </div>
        <!-- /carousel -->
    </div>
</div>