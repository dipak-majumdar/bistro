{{-- 
Useage:
window.showToast('Saved successfully', { variant: 'success', delay: 2000 });
window.showToast(message, { variant: 'danger'}); // default 3000ms
window.showToast('Heads up!', { variant: 'warning', delay: 5000 }); --}}

<style>
    /* Global Toast container styles */
    #liveToastContainer {
        z-index: 2147483647 !important; /* above Magnific Popup */
        position: fixed;
        /* top: 0; */
        /* right: 0; */
        pointer-events: none; /* container ignores clicks */
    }
    #liveToastContainer .toast {
        pointer-events: auto; /* allow clicks on the toast */
        position: relative;
        z-index: inherit;
    }
    /* Cancel Magnific Popup blur on the toast container and its children */
    .mfp-wrap ~ #liveToastContainer,
    .mfp-wrap ~ #liveToastContainer * {
        -webkit-filter: none !important;
        -moz-filter: none !important;
        -o-filter: none !important;
        -ms-filter: none !important;
        filter: none !important;
        backdrop-filter: none !important;
    }
</style>

<div id="liveToastContainer" class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3"></div>

<script>
// Global Toast helper
window.showToast = function(message, options = {}) {
    const variant = options.variant || 'primary'; // 'success', 'danger', 'warning', etc.
    const delay = Number.isFinite(options.delay) ? options.delay : 3000;

    // Ensure container exists and is the last child of <body>
    const containerId = 'liveToastContainer';
    let container = document.getElementById(containerId);
    if (!container) {
        container = document.createElement('div');
        container.id = containerId;
        container.className = 'toast-container position-fixed bottom-0 start-50 translate-middle-x p-3';
        document.body.appendChild(container);
    } else {
        document.body.appendChild(container);
    }
    container.style.zIndex = '2147483647';

    // Build toast element
    const toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center text-bg-${variant} border-0`;
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>`;
    container.appendChild(toastEl);

    // Show toast via Bootstrap (fallback to alert if not available)
    try {
        const toast = new bootstrap.Toast(toastEl, { delay });
        toast.show();
    } catch (e) {
        alert(message);
    }
}
</script>
