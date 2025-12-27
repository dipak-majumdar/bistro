@extends('layouts.web.user-portal.main-layout')

@section('main')
    <div class="container px-3 px-md-4 d-flex align-items-center justify-content-center h-100">
        <section aria-labelledby="welcome-heading">
            <div class="card mx-auto" style="max-width: 900px;">
                <div class="card-body text-center p-4 p-sm-5">
                    <h1 id="welcome-heading" class="display-6 fw-bold text-dark mb-2">
                        Welcome back, {{ Auth::user()->name ?? 'there' }}!
                    </h1>

                    <p class="lead text-muted mb-3">
                        Hungry? We make ordering quick and delicious. Browse our menu and get your favourite meals delivered or ready for pickup.
                    </p>

                    <div class="mt-3 d-flex flex-column flex-sm-row justify-content-center align-items-center gap-2">
                        <a href="{{ url('/') }}" role="button" class="btn btn-primary btn-lg d-inline-flex align-items-center" style="background: #e54750 !important; border-color: #e54750 !important;">
                            <svg class="bi bi-basket me-2" width="20" height="20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M8 1a2 2 0 0 0-2 2v1H2.5A1.5 1.5 0 0 0 1 5.5v1A1.5 1.5 0 0 0 2.5 8H3l1 6.5A1.5 1.5 0 0 0 5.5 16h5a1.5 1.5 0 0 0 1.5-1.5L13 8h.5A1.5 1.5 0 0 0 15 6.5v-1A1.5 1.5 0 0 0 13.5 4H10V3a2 2 0 0 0-2-2z"/>
                            </svg>
                            Order Now
                        </a>

                        <a href="{{ url('/menu') }}#specials" class="small text-primary text-decoration-none ms-0 ms-sm-3 mt-2 mt-sm-0">
                            See today's specials
                        </a>
                    </div>

                    <p class="mt-3 small text-muted mb-0">
                        Fast. Fresh. Local. — This area is reserved only for welcome & ordering actions.
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection

