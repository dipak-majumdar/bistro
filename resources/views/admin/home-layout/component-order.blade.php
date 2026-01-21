@extends('layouts.admin.layout')

@section('additional-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
@endsection

@section('content')
    <div class="grid lg:grid-cols-2 gap-6 mt-8">
        <!-- Available Components -->
        <div class="card bg-transparent dark:border-gray-400">
            <div class="p-6">
                <h4 class="card-title dark:text-gray-300 mb-4">Available Components</h4>
                <div id="available-components" class="space-y-2">
                    @foreach($availableComponents as $key => $name)
                        <div class="component-item bg-gray-50 dark:bg-gray-700 p-3 rounded-lg cursor-move border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow" data-component="{{ $name->component }}">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h5 class="font-medium text-gray-800 dark:text-gray-200">{{ $name->name }}</h5>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $name->component }}</p>
                                </div>
                                <div class="text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Current Component Order -->
        <div class="card bg-transparent dark:border-gray-400">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="card-title dark:text-gray-300">Component Order</h4>
                    <button type="button" id="save-order" class="btn bg-primary text-white hover:bg-primary/90">
                        Save Order
                    </button>
                </div>
                
                <form id="order-form" action="{{ route('admin.component-order.update') }}" method="POST" class="hidden">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="components" id="components-input">
                </form>

                <div id="ordered-components" class="space-y-2 min-h-[200px] border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-4">
                    @if($components->isEmpty())
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            <p>No components added yet.</p>
                            <p class="text-sm">Drag components from the left to start building your layout.</p>
                        </div>
                    @else
                        @foreach($components as $component)
                            <div class="component-item bg-white dark:bg-gray-800 p-3 rounded-lg cursor-move border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow" data-component-id="{{ $component->id }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h5 class="font-medium text-gray-800 dark:text-gray-200">{{ $component->name }}</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $component->component }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs px-2 py-1 rounded-full {{ $component->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ $component->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <button type="button" class="remove-component text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('alerts')
    @if (session('success'))
        <x-admin.alert type="success" :message="session('success')" />
    @endif
    @if (session('error'))
        <x-admin.alert type="error" :message="session('error')" />
    @endif
@endpush

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const availableComponents = document.getElementById('available-components');
            const orderedComponents = document.getElementById('ordered-components');
            const saveButton = document.getElementById('save-order');
            const orderForm = document.getElementById('order-form');
            const componentsInput = document.getElementById('components-input');

            // Initialize Sortable for available components
            new Sortable(availableComponents, {
                group: {
                    name: 'components',
                    pull: 'clone',
                    put: false
                },
                sort: false,
                animation: 150,
                onEnd: function(evt) {
                    // Remove the cloned element after drag
                    if (evt.from === availableComponents && evt.to === orderedComponents) {
                        // Convert available component to ordered component
                        const item = evt.item;
                        const componentName = item.dataset.component;
                        
                        // Find if this component exists in our database
                        fetch(`/api/admin/component/by-name/${componentName}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.data) {
                                    item.dataset.componentId = data.data.id;
                                    item.innerHTML = `
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h5 class="font-medium text-gray-800 dark:text-gray-200">${data.data.name}</h5>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">${data.data.component}</p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <span class="text-xs px-2 py-1 rounded-full ${data.data.is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'}">
                                                    ${data.data.is_active ? 'Active' : 'Inactive'}
                                                </span>
                                                <button type="button" class="remove-component text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    `;
                                    addRemoveListener(item);
                                } else {
                                    // If component doesn't exist in database, remove it
                                    console.log(data.data)
                                    item.remove();
                                    showNotification('Component not found in database', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching component:', error);
                                item.remove();
                                showNotification('Error loading component data', 'error');
                            });
                    }
                }
            });

            // Initialize Sortable for ordered components
            new Sortable(orderedComponents, {
                group: 'components',
                animation: 150,
                onAdd: function(evt) {
                    // Handle empty state message
                    const emptyMessage = orderedComponents.querySelector('.text-center');
                    if (emptyMessage) {
                        emptyMessage.remove();
                    }
                },
                onRemove: function(evt) {
                    // Show empty message if no components left
                    if (orderedComponents.children.length === 0) {
                        orderedComponents.innerHTML = `
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                <p>No components added yet.</p>
                                <p class="text-sm">Drag components from the left to start building your layout.</p>
                            </div>
                        `;
                    }
                }
            });

            // Add remove listener to existing remove buttons
            document.querySelectorAll('.remove-component').forEach(addRemoveListener);

            function addRemoveListener(button) {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const item = this.closest('.component-item');
                    item.remove();
                    
                    // Show empty message if no components left
                    if (orderedComponents.children.length === 0) {
                        orderedComponents.innerHTML = `
                            <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                                <p>No components added yet.</p>
                                <p class="text-sm">Drag components from the left to start building your layout.</p>
                            </div>
                        `;
                    }
                });
            }

            // Save order
            saveButton.addEventListener('click', function() {
                const componentItems = orderedComponents.querySelectorAll('.component-item[data-component-id]');
                const componentIds = Array.from(componentItems).map(item => item.dataset.componentId);
                
                if (componentIds.length === 0) {
                    showNotification('No components to save', 'error');
                    return;
                }
                
                // Send as array instead of JSON string
                const formData = new FormData(orderForm);
                formData.delete('components'); // Remove existing value
                
                // Add each component ID as separate array element
                componentIds.forEach((id, index) => {
                    formData.append(`components[${index}]`, id);
                });
                
                // Submit with FormData
                fetch(orderForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-HTTP-Method-Override': 'PUT'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        // if (data.redirect) {
                        //     setTimeout(() => {
                        //         window.location.href = data.redirect;
                        //     }, 3000);
                        // }
                    }else{
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error updating component order', 'error');
                });
            });
        });
    </script>
@endsection
