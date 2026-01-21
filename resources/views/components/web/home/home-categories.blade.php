<div class="container margin_30_60">
    <div class="main_title center">
        <span><em></em></span>
        <h2>Popular Categories</h2>
        <p>From starters to desserts—flavor in every category</p>
    </div>
    <!-- /main_title -->
    <div class="owl-carousel owl-theme categories_carousel">
        @foreach ($categories as $category)
        <div class="item_version_2">
            <a href="{{ route('category-details', $category->slug) }}">
                <figure>
                    <span>{{ $category->menu_items_count ?? 0 }}</span>
                    <img src="{{ asset('storage/' . $category->image) ?? asset('assets/web/img/home_cat_hamburgher.jpg') }}" alt=""
                        class="owl-lazy">
                    <div class="info">
                        <h3>{{ $category->name }}</h3>
                        <small>Avg price $40</small>
                    </div>
                </figure>
            </a>
        </div>
        @endforeach
    </div>
    <!-- /carousel -->
</div>
<!-- /container -->