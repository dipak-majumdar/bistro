<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    @yield('additional-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-admin.meta-tags />
    <x-admin.header-links />

</head>

<body>

    <div class="wrapper">

        <!-- Start Sidebar -->
        <x-admin.sidebar-nav />
        <!-- End Sidebar -->


        <!-- Mobile Nav Start -->
        <x-admin.mobile-nav />
        <!-- Mobile Nav End -->

        <!-- Start Page Content here -->
        <div class="page-content bg-white dark:bg-gray-900 dark:text-white">

            <!-- Topbar Start -->
            <x-admin.topbar />
            <!-- Topbar End -->
            
            <main class="bg-white dark:bg-gray-800 dark:text-white">
                <div class="container py-6">

                    @yield('content')
                    
                </div>
            </main>
            @yield('offcanvas')

        </div>
        <!-- End Page content -->

    </div>

    @stack('alerts')

    @yield('js')
    
    <x-admin.footer-js />

</body>

</html>