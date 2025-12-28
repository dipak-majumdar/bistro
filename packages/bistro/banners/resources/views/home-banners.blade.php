@php
    $banners = \Bistro\Banners\Models\Banner::active()
        ->position('home')
        ->currentlyActive()
        ->ordered()
        ->get();
@endphp

@if($banners->isNotEmpty())
    <div id="homeBanners" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($banners as $index => $banner)
                <button type="button" data-bs-target="#homeBanners" 
                        data-bs-slide-to="{{ $index }}" 
                        class="{{ $index == 0 ? 'active' : '' }}"
                        aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach($banners as $index => $banner)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <picture>
                        <source media="(max-width: 768px)" 
                                srcset="{{ $banner->mobile_image_url ?? $banner->image_url }}">
                        <img src="{{ $banner->image_url }}" 
                             class="d-block w-100" 
                             alt="{{ $banner->title }}"
                             style="height: 500px; object-fit: cover;">
                    </picture>
                    
                    <div class="carousel-overlay d-flex align-items-center">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 text-center text-white">
                                    @if($banner->title)
                                        <h1 class="display-4 fw-bold mb-3">{{ $banner->title }}</h1>
                                    @endif
                                    
                                    @if($banner->description)
                                        <p class="lead mb-4">{{ $banner->description }}</p>
                                    @endif
                                    
                                    @if($banner->button_text && $banner->button_url)
                                        <a href="{{ $banner->button_url }}" class="btn btn-lg btn-primary">
                                            {{ $banner->button_text }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($banners->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#homeBanners" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homeBanners" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif
    </div>
@endif

<style>
.carousel-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
}

.carousel-item img {
    filter: brightness(0.9);
}

@media (max-width: 768px) {
    .carousel-overlay .display-4 {
        font-size: 2rem;
    }
    
    .carousel-overlay .lead {
        font-size: 1rem;
    }
}
</style>
