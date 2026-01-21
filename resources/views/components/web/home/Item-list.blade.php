<div class="bg_gray">
    <div class="container margin_detail">
        <div class="row">
            <div class="list_menu">

                <div class="d-flex justify-content-center">
                    <nav class="secondary_nav sticky_horizontal">
                        <div class="container">
                            <ul id="secondary_nav">
                                <li><a href="#section-1">Starters</a></li>
                                <li><a href="#section-2">Main Courses</a></li>
                                <li><a href="#section-3">Desserts</a></li>
                                <li><a href="#section-4">Drinks</a></li>
                            </ul>
                        </div>
                        <span></span>
                    </nav>
                </div>

                @foreach ($categorywithitems as $category)
                <section id="section-{{ $category->id }}">
                    <div class="d-flex justify-content-between">
                        <h4>{{ $category->name }}</h4>
                        <a href="{{ route('category-details', $category->slug) }}" class="">View All <i class="bi bi-arrow-right"></i></a>
                    </div>
                    <div class="row">
                        @foreach ($category->items as $item)
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" onclick="showItemDetails({{ $item->id }})" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ $item->images->count() > 0 ? asset('storage/' . $item->images->first()->image_path) : asset('assets/web/img/menu-thumb-1.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>{{ $item->name }}</h3>
                                <p>{{ $item->description }}</p>
                                <strong>{{ config('app.currency') }}{{ $item->price }}</strong>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <!-- /row -->
                </section>
                @endforeach
                <!-- /section -->
                {{-- <section id="section-2">
                    <h4>Main Courses</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-5.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>5. Cheese Quesadilla</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-6.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>6. Chorizo & Cheese</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-7.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>7. Beef Taco</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-8.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>8. Minced Beef Double Layer</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-9.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>9. Piri Piri Chicken</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-10.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>10. Burrito Al Pastor</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                    </div>
                    <!-- /row -->
                </section>
                <!-- /section -->
                <section id="section-3">
                    <h4>Desserts</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-5.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>5. Cheese Quesadilla</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-6.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>6. Chorizo & Cheese</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-7.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>7. Beef Taco</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-8.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>8. Minced Beef Double Layer</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-9.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>9. Piri Piri Chicken</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-10.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>10. Burrito Al Pastor</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                    </div>
                    <!-- /row -->
                </section>
                <!-- /section -->
                <section id="section-4">
                    <h4>Drinks</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-5.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>11. Coca Cola</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$2.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-6.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>12. Corona Beer</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$9.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-7.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>13. Red Wine</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$19.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-8.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>14. White Wine</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$19.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-9.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>15. Mineral Water</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$1.40</strong>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a class="menu_item modal_dialog" href="#modal-dialog">
                                <figure><img src="{{ asset('assets/web/img/menu-thumb-placeholder.jpg') }}"
                                        data-src="{{ asset('assets/web/img/menu-thumb-10.jpg') }}" alt="thumb"
                                        class="lazy"></figure>
                                <h3>16. Red Bull</h3>
                                <p>Fuisset mentitum deleniti sit ea.</p>
                                <strong>$3.40</strong>
                            </a>
                        </div>
                    </div>
                    <!-- /row -->
                </section> --}}
                <!-- /section -->
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
