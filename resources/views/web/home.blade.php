@extends('web.web-layout')
@section('header')
    <link href="{{ asset('assets/web/css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/web/css/detail-page.css') }}" rel="stylesheet">
@endsection
@section('main')

    @foreach ($components as $component)
        @switch($component->homeLayout->component)
            @case('first-banner')
                <x-web.home.first-banner />
                @break
            @case('home-categories')
                <x-web.home.home-categories :categories="$categories" />
                @break
            @case('home-hero')
                <x-web.home.home-hero />
                @break
            @case('Item-list')
                <x-web.home.Item-list :categorywithitems="$categoryWithItems" />
                @break
            @case('large-cards-slider')
                <x-web.home.large-cards-slider />
                @break
            @case('popular-items')
                <x-web.home.popular-items :items="$mostOrderedItems" />
                @break
        @endswitch
    @endforeach

@endsection

@section('elements')
    <!-- Modal item order -->
    <div id="modal-dialog" class="zoom-anim-dialog mfp-hide">
        <div class="small-dialog-header">
            <h3 id="modal-item-name">Cheese Quesadilla</h3>
        </div>
        <div class="content">
            <h5>Quantity</h5>
            <div class="numbers-row">
                <input type="text" value="1" id="item_qty" class="qty2 form-control" name="quantity">
            </div>
            <div id="modal-variation-list" class="ul-box">
            </div>
            <div class="bg-body-secondary d-flex justify-content-between rounded px-2 py-3 mb-2">
                <h5 class="mb-0">Total</h5>
                <h5 class="mb-0">@php echo config('app.currency') @endphp <span id="total">0</span></h5>
            </div>
        </div>
        <div class="footer">
            <div class="row small-gutters">
                <div class="col-md-4">
                    <button type="reset" class="btn_1 outline full-width mb-mobile">Cancel</button>
                </div>
                <div class="col-md-8">
                    <button type="button" class="btn_1 full-width" id="add-to-cart">Add to cart</button>
                </div>
            </div>
            <!-- /Row -->
        </div>
    </div>
    <!-- /Modal item order -->
@endsection

@section('custom-js')
<script>

    // Track selected prices by variation group
    const selectedPrices = {};
    const totalElement = document.getElementById('total');

    function showItemDetails(itemId) {
        // Reset selected prices when showing new item
        Object.keys(selectedPrices).forEach(key => delete selectedPrices[key]);
        document.getElementById('total').textContent = '0.00';

        fetch(`/item/${itemId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modal-item-name').textContent = data.name;
            document.getElementById('modal-item-name').dataset.productId = data.id;
            const variationList = document.getElementById('modal-variation-list');
            variationList.innerHTML = '';

            data.grouped_variations.forEach(variation => {
                // Create variation type heading
                const heading = document.createElement('h5');
                heading.textContent = variation.variation_type_name;

                // Create UL for variation options
                const ul = document.createElement('ul');
                ul.className = 'clearfix';

                // Add radio buttons for each variation option
                variation.variations.forEach(eachvariation => {
                    const li = document.createElement('li');
                    li.innerHTML = `
                        <label class="container_radio">
                            ${eachvariation.name}
                            <span>+ @php echo config('app.currency') @endphp ${parseFloat(eachvariation.price).toFixed(2)}</span>
                            <input type="radio"
                                value="${eachvariation.id}"
                                name="variation_${variation.variation_type_id}"
                                data-price="${eachvariation.price}"
                                onclick="handleVariationClick(event, '${variation.variation_type_id}', this)">
                            <span class="checkmark"></span>
                        </label>`;
                    ul.appendChild(li);
                });

                // Append heading and list to the container
                variationList.appendChild(heading);
                variationList.appendChild(ul);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function updateTotalPrice(quantity) {
        const qty = parseInt(quantity) || 1;

        // Calculate sum of all selected variation prices
        let variationsTotal = 0;
        const variationInputs = document.querySelectorAll('input[name^="variation_"]:checked');
        variationInputs.forEach(input => {
            variationsTotal += parseFloat(input.dataset.price) || 0;
        });

        // Calculate total (variations * quantity)
        const newTotal = variationsTotal * qty;
        totalElement.textContent = newTotal.toFixed(2);

    }

    function handleVariationClick(event, variationTypeId, element) {
        const quantity = parseInt(document.getElementById('item_qty').value) || 1;
        const newPrice = parseFloat(element.dataset.price) || 0;
        totalElement.textContent = (quantity * newPrice).toFixed(2);
    }


    document.getElementById('add-to-cart').addEventListener('click', function() {
        const itemId = document.getElementById('modal-item-name').dataset.productId;
        const quantity = document.getElementById('item_qty').value;
        const total = document.getElementById('total').textContent;

        // Get all checked variation inputs
        const variationInputs = document.querySelectorAll('input[name^="variation_"]:checked');

        const variations = Array.from(variationInputs).map(input => ({
            variation_type_id: input.name.split('_')[1], // Extract the ID after the underscore,
            variation_id: input.value
        }));

        // Validation: require at least one variation OR price > 0
        const totalNumber = parseFloat(total);
        if ((variations.length === 0) && (!Number.isFinite(totalNumber) || totalNumber <= 0)) {
            // Show Bootstrap toast (fallback to alert if Bootstrap is unavailable)
            const message = 'Please select at least one variation or ensure the price is more than 0.';
            try {
                window.showToast(message, { variant: 'danger', delay: 4000 }); // default 3000ms
            } catch (e) {
                // Fallback if Bootstrap is not loaded
                alert(message);
            }
            return;
        }

        (async () => {
            try {

                const res = await fetch('/api/cart/items', {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify({
                        menu_item_id: parseInt(itemId),
                        quantity: parseInt(quantity) || 1,
                        variation_ids: variations.map(v => parseInt(v.variation_id)),
                    }),
                });
                const contentType = res.headers.get('content-type') || '';
                const data = contentType.includes('application/json') ? await res.json() : { message: await res.text() };
                if (!res.ok || data.success === false) {
                    throw new Error(data.message || 'Failed to add to cart');
                }
                // Notify UI
                fetchCartAndRender();
                window.showToast('Added to cart', { variant: 'success', delay: 2000 });
                window.dispatchEvent(new CustomEvent('cart:updated'));
            } catch (err) {
                console.error(err);
                window.showToast('Could not add to cart', { variant: 'danger' });
            }
        })();
    });
</script>
<script src="{{ asset('assets/web/js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('assets/web/js/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/web/js/specific_detail.js') }}"></script>
@endsection
