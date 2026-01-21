@vite(['resources/js/admin-app.js'])

<!-- Plugin Js (Mandatory in All Pages) -->
<script src="{{ admin_asset('libs/jquery/jquery.min.js') }}"></script>
<script src="{{ admin_asset('libs/preline/preline.js') }}"></script>
<script src="{{ admin_asset('libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ admin_asset('libs/lucide/umd/lucide.min.js') }}"></script>
<script src="{{ admin_asset('libs/iconify-icon/iconify-icon.min.js') }}"></script>
<script src="{{ admin_asset('libs/node-waves/waves.min.js') }}"></script>

<!-- App Js (Mandatory in All Pages) -->
<script src="{{ admin_asset('js/app.js') }}"></script>
<script>
    function showNotification(message, type = 'success') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
                    type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
</script>
