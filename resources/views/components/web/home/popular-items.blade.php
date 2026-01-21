<div class="bg_gray">
    <div class="container margin_60_40">
        <div class="main_title">
            <span><em></em></span>
            <h2>Most Ordered Today</h2>
            <p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
            <a href="#0">View All &rarr;</a>
        </div>
        <div class="row add_bottom_25">
            <div class="col-lg-6">
                <div class="list_home">
                    <ul>
                        @foreach ($items->take(ceil(count($items) / 2)) as $item)
                        <li>
                            <a href="detail-restaurant.html">
                                <figure>
                                    <img src="{{ asset('assets/web/img/location_list_placeholder.png') }}" data-src="{{ $item->images->count() > 0 ? asset('storage/' . $item->images->first()->image_path) : asset('assets/web/img/location_list_1.jpg') }}"
                                        alt="{{ $item->name }}" class="lazy">
                                </figure>
                                <div class="score"><strong>9.5</strong></div>
                                <em>{{ $item->category_name }}</em>
                                <h3>{{ $item->name }}</h3>
                                <small>{{ $item->description }}</small>
                                <ul>
                                    <li><span class="ribbon off">-{{ $item->discount }}%</span></li>
                                    <li>Average price {{ env('CURRENCY') }}{{ $item->mrp }}</li>
                                </ul>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="list_home">
                    <ul>
                        @foreach ($items->skip(ceil(count($items) / 2)) as $item)
                        <li>
                            <a href="detail-restaurant.html">
                                <figure>
                                    <img src="{{ asset('assets/web/img/location_list_placeholder.png') }}" data-src="{{ $item->images->count() > 0 ? asset('storage/' . $item->images->first()->image_path) : asset('assets/web/img/location_list_1.jpg') }}"
                                        alt="{{ $item->name }}" class="lazy">
                                </figure>
                                <div class="score"><strong>9.5</strong></div>
                                <em>{{ $item->category_name }}</em>
                                <h3>{{ $item->name }}</h3>
                                <small>{{ $item->description }}</small>
                                <ul>
                                    <li><span class="ribbon off">-{{ $item->discount }}%</span></li>
                                    <li>Average price ${{ $item->mrp }}</li>
                                </ul>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
</div>
