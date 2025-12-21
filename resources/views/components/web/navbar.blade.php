<header class="header black_nav clearfix element_to_stick">
    <div class="container">
        <div id="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/site/logo.png') }}" width="120" alt="">
            </a>
        </div>
        <div class="layer"></div><!-- Opacity Mask Menu Mobile -->
        <ul id="top_menu" class="drop_user">
            <li>
                <div class="dropdown dropdown-cart">
                    <a href="{{ route('checkout') }}" class="cart_bt"><strong>0</strong></a>
                    <div class="dropdown-menu">
                        <ul>
                            {{-- Cart Items Goes Here --}}
                        </ul>
                        <div class="total_drop">
                            <div class="clearfix add_bottom_15"><strong>Total</strong><span id="cart_total"></span></div>
                            <a href="{{ route('checkout') }}" class="btn_1">Checkout</a>
                        </div>
                    </div>
                </div>
                <!-- /dropdown-cart-->
            </li>

            @auth
            <li>
                <div class="dropdown user clearfix">
                    <a href="#" data-bs-toggle="dropdown">
                        <figure><img src="{{ asset('assets/web/img/avatar.jpg') }}" alt=""></figure>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-content">
                            <ul>
                                <li><a href="{{ route('dashboard') }}"><i class="icon_cog"></i>Dashboard</a></li>
                                <li><a href="#0"><i class="icon_document"></i>Bookings</a></li>
                                <li><a href="#0"><i class="icon_heart"></i>Wish List</a></li>
                                <li><hr class="dropdown-divider m-0"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item logout-item"> <i class="icon_key"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /dropdown -->
            </li>
            @else
            <li><a href="#sign-in-dialog" id="sign-in" class="login">Sign In</a></li>
            @endauth
        </ul>
        <!-- /top_menu -->
        <a href="#0" class="open_close">
            <i class="icon_menu"></i><span>Menu</span>
        </a>
        <nav class="main-menu">
            <div id="header_menu">
                <a href="#0" class="open_close">
                    <i class="icon_close"></i><span>Menu</span>
                </a>
                <a href="index.html"><img src="{{ asset('assets/site/logo.png') }}" width="162" height="35" alt=""></a>
            </div>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#0">Listing</a></li>
                <li><a href="#0">Other Pages</a></li>
                <li><a href="{{ route('categories') }}">Categories</a></li>
            </ul>
        </nav>
    </div>
</header>
<script>
    // const isLoggedIn = {{Auth::check() ? Auth::check() : false}};
    // const userId = {{ Auth::id() }};
</script>