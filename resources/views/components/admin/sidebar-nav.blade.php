@php
    // Get all menu items (packages automatically merge their items into admin-menu.items)
    $menuItems = collect(config('admin-menu.items', []))
        ->sortBy('priority')
        ->values()
        ->all();
    
    $currentRoute = request()->route() ? request()->route()->getName() : '';
    
    function isActive($item, $currentRoute) {
        if (isset($item['route'])) {
            // Exact match
            if ($item['route'] === $currentRoute) {
                return true;
            }
            // Pattern match (e.g., 'admin.banners' matches 'admin.banners.*')
            if (strpos($currentRoute, $item['route'] . '.') === 0) {
                return true;
            }
        }
        if (isset($item['children'])) {
            foreach ($item['children'] as $child) {
                if (isActive($child, $currentRoute)) {
                    return true;
                }
            }
        }
        return false;
    }
    
    function getUrl($item) {
        if (isset($item['route'])) {
            return route($item['route']);
        }
        if (isset($item['url'])) {
            return $item['url'];
        }
        return '#';
    }
@endphp

<aside id="app-menu"
    class="bg-white dark:bg-gray-900 hs-overlay fixed inset-y-0 start-0 z-60 hidden w-sidenav min-w-sidenav -translate-x-full transform overflow-y-auto bg-body transition-all duration-300 hs-overlay-open:translate-x-0 lg:bottom-0 lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full rtl:hs-overlay-open:translate-x-0 rtl:lg:translate-x-0 print:hidden [--body-scroll:true] [--overlay-backdrop:true] lg:[--overlay-backdrop:false]">
    <div class="sticky top-0 flex h-16 items-center justify-center px-6">
        <a href="index.html">
            <img src="{{ admin_asset('images/logo-dark.png') }}" alt="logo" class="flex h-10">
        </a>
    </div>

    <div class="h-[calc(100%-64px)] p-4 lg:ps-8" data-simplebar>
        <ul class="admin-menu hs-accordion-group flex w-full flex-col gap-1.5">
            @foreach($menuItems as $item)
                @if($item['type'] === 'divider')
                    <li class="px-5 py-2 text-sm font-medium text-default-600 dark:text-gray-400">{{ $item['label'] }}</li>
                @elseif($item['type'] === 'link')
                    @php
                        $isActive = isActive($item, $currentRoute);
                        $url = getUrl($item);
                    @endphp
                    <li class="menu-item">
                        <a href="{{ $url }}"
                            class="group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 dark:text-gray-400 transition-all hover:bg-default-900/5 {{ $isActive ? 'hs-accordion-active:bg-default-900/5 hs-accordion-active:text-default-700' : '' }}">
                            @if(isset($item['icon']))
                                <i data-lucide="{{ $item['icon'] }}" class="size-5"></i>
                            @endif
                            <span class="menu-text">{{ $item['label'] }}</span>
                            @if(isset($item['badge']))
                                <span class="ms-auto inline-flex items-center gap-x-1.5 py-0.5 px-2 rounded-md font-semibold text-xs {{ $item['badge']['class'] ?? 'bg-gray-800 text-white' }}">{{ $item['badge']['text'] }}</span>
                            @endif
                        </a>
                    </li>
                @elseif($item['type'] === 'accordion')
                    @php
                        $isActive = isActive($item, $currentRoute);
                        $hasActiveChild = false;
                        if (isset($item['children'])) {
                            foreach ($item['children'] as $child) {
                                if (isActive($child, $currentRoute)) {
                                    $hasActiveChild = true;
                                    break;
                                }
                            }
                        }
                    @endphp
                    <li class="menu-item hs-accordion">
                        <a href="javascript:void(0)"
                            class="hs-accordion-toggle group flex items-center gap-x-4 rounded-md px-3 py-2 text-sm font-medium text-default-700 dark:text-gray-400 transition-all hover:bg-default-900/5 {{ $isActive || $hasActiveChild ? 'hs-accordion-active:bg-default-900/5 hs-accordion-active:text-default-700 hs-accordion-active:dark:text-gray-400' : '' }}">
                            @if(isset($item['icon']))
                                <i data-lucide="{{ $item['icon'] }}" class="size-5"></i>
                            @endif
                            <span class="menu-text">{{ $item['label'] }}</span>
                            <span class="i-tabler-chevron-right ms-auto text-sm transition-all hs-accordion-active:rotate-90"></span>
                        </a>

                        @if(isset($item['children']))
                            @php
                                $children = collect($item['children'])
                                    ->sortBy('priority')
                                    ->values()
                                    ->all();
                            @endphp
                            <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                                <ul class="mt-2 space-y-2">
                                    @foreach($children as $child)
                                        @php
                                            $childIsActive = isActive($child, $currentRoute);
                                            $childUrl = getUrl($child);
                                        @endphp
                                        <li class="menu-item">
                                            <a href="{{ $childUrl }}"
                                                class="flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-700 dark:text-gray-400 hover:bg-default-900/5 {{ $childIsActive ? 'bg-default-900/5' : '' }}">
                                                <i class="i-tabler-circle-filled scale-25 text-lg opacity-75"></i>
                                                <span class="menu-text">{{ $child['label'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
