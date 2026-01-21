@extends('layouts.admin.layout')

@section('additional-meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="grid lg:grid-cols-2 gap-6 mt-8">
        <div class="card bg-transparent dark:border-gray-400">
            <div class="p-6">
                <div class="flex justify-between items-center px-4 pt-2">
                    <h4 class="card-title dark:text-gray-300 mb-4">Component</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="responsive-table w-full">
                        <thead>
                            <tr>
                                <th scope="col" class="px-4 py-3 text-start text-sm text-default-500">
                                    Name</th>
                                <th scope="col" class="px-4 py-3 text-start text-sm text-default-500">
                                    Component
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-sm text-default-500">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3 text-center text-sm text-default-500">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($components as $eachComponent)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td
                                        class="px-4 py-3 whitespace-nowrap text-sm font-medium text-default-800 dark:text-gray-400">
                                        {{ $eachComponent->name }}
                                    </td>
                                    <td
                                        class="px-4 py-3 whitespace-nowrap text-sm font-medium text-default-800 dark:text-gray-400">
                                        {{ $eachComponent->component }}</td>
                                    <td class="px-4 py-3 whitespace-wrap text-sm text-default-800 dark:text-gray-400">
                                        @if ($eachComponent->is_active)
                                            <span
                                                class="px-3 py-0.5 text-xs font-normal rounded-lg text-white bg-green-800 ">Active</span>
                                        @else
                                            <span
                                                class="px-3 py-0.5 text-xs font-normal rounded-lg bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 ">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                                        <button class="text-white bg-transparent px-2 py-1" x-data
                                            @click="$dispatch('toggle-drawer')"
                                            onclick="editComponent({{ $eachComponent->id }})">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                                width="24px" fill="#5f6368" class="dark:hover:fill-white">
                                                <path
                                                    d="M200-200h57l391-391-57-57-391 391v57Zm-40 80q-17 0-28.5-11.5T120-160v-97q0-16 6-30.5t17-25.5l505-504q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L313-143q-11 11-25.5 17t-30.5 6h-97Zm600-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                            </svg>
                                        </button>
                                        <button class="text-white bg-transparent py-1"
                                            onclick="deleteComponent({{ $eachComponent->id }}, this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                                width="24px" fill="#5f6368" class="dark:hover:fill-white">
                                                <path
                                                    d="M280-120q-33 0-56.5-23.5T200-200v-520q-17 0-28.5-11.5T160-760q0-17 11.5-28.5T200-800h160q0-17 11.5-28.5T400-840h160q17 0 28.5 11.5T600-800h160q17 0 28.5 11.5T800-760q0 17-11.5 28.5T760-720v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM400-280q17 0 28.5-11.5T440-320v-280q0-17-11.5-28.5T400-640q-17 0-28.5 11.5T360-600v280q0 17 11.5 28.5T400-280Zm160 0q17 0 28.5-11.5T600-320v-280q0-17-11.5-28.5T560-640q-17 0-28.5 11.5T520-600v280q0 17 11.5 28.5T560-280ZM280-720v520-520Z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card bg-transparent dark:border-gray-400">
            <div class="p-6">
                <h4 class="card-title dark:text-gray-300 mb-4">Add Component</h4>

                <form action="{{ route('admin.home-component.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 col-span-4">
                        <div>
                            <x-tailwind.floating.text-input class="mb-0" name="name" label="Component Name" />
                            @error('name')
                                <p class="mt-1 text-xs text-red-600 mb-4">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-tailwind.floating.dropdown name="component" label="Component" :listArray="$componentFiles"
                                listValue="id" listLabel="name" :value="old('component')" />
                            @error('component')
                                <p class="mt-1 text-xs text-red-600 mb-4">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <div>
                                <x-tailwind.floating.switch name="is_active" label="Status" />
                                @error('is_active')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <div class="text-end">
                                    <button type="submit" class="btn bg-primary text-white">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('offcanvas')
    <x-tailwind.offcanvas title="Edit Component">
        <div id="edit-component-container">
            <form id="edit-component-form" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3 col-span-4">
                    <div>
                        <x-tailwind.floating.text-input class="mb-0" name="name" label="Component Name"
                            id="edit_name" />
                        @error('name')
                            <p class="mt-1 text-xs text-red-600 mb-4">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-tailwind.floating.dropdown name="component" id="edit_component" label="Component"
                            :listArray="$componentFiles" listValue="id" listLabel="name" :value="old('component')" />
                        @error('component')
                            <p class="mt-1 text-xs text-red-600 mb-4">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between">
                        <div>
                            <x-tailwind.floating.switch name="is_active" label="Status" id="edit_status" />
                            @error('is_active')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <div class="text-end">
                                <button type="submit" class="btn bg-primary text-white">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </x-tailwind.offcanvas>
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
        const editComponent = (componentId) => {
            fetch(`/api/admin/component/${componentId}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.data) {
                        // Populate form fields with the fetched data
                        document.getElementById('edit_name').value = data.data.name || '';
                        document.getElementById('edit_component').value = data.data.component || '';
                        document.getElementById('edit_status').checked = data.data.is_active || false;

                        // Update form action if needed
                        const form = document.getElementById('edit-component-form');
                        if (form) {
                            form.action = `/api/admin/component/${componentId}`;
                        }
                    } else {
                        console.error('No data received:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching component:', error);
                });
        }

        // Handle edit form submission
        document.getElementById('edit-component-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const componentId = this.action.split('/').pop();

            // Try normal FormData first
            const formData = new FormData(this);

            // Handle checkbox for is_active - ensure unchecked boxes send '0'
            const isActiveCheckbox = document.getElementById('edit_status');
            if (isActiveCheckbox.checked) {
                formData.set('is_active', '1');
            } else {
                formData.set('is_active', '0');
            }

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'X-HTTP-Method-Override': 'PUT'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.success) {
                        showNotification(data.message);

                        // Close the offcanvas
                        const offcanvasElement = document.querySelector('[data-bs-dismiss="offcanvas"]');
                        if (offcanvasElement) {
                            offcanvasElement.click();
                        }
                        // Reload the page to show updated data
                        location.reload();

                    } else {
                        showNotification(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error updating component:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to update component'
                    });
                });
        });

        const deleteComponent = (componentId, element) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/admin/component/${componentId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        Swal.fire(
                            'Deleted!',
                            'Component has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                            element.closest('tr').remove();
                        });
                    })
                    .catch(error => {
                        Swal.fire(
                            'Error!',
                            error.message || 'Failed to delete component',
                            'error'
                        );
                    });
                }
            });
        };

    </script>
@endsection
