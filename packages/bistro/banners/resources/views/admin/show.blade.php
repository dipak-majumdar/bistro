@extends('layouts.admin.layout')

@section('title', 'Banner Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Banner Details</h1>
        <a href="{{ route('admin.banners') }}" class="bg-gray-600 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Banners
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-200 dark:border-gray-600">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $banner->title }}</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</span>
                            <div class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $banner->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Position</span>
                            <div class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                    {{ ucfirst($banner->position) }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Sort Order</span>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $banner->sort_order }}</div>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</span>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $banner->created_at->format('M d, Y H:i') }}</div>
                        </div>
                        @if($banner->starts_at)
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Date</span>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $banner->starts_at->format('M d, Y H:i') }}</div>
                        </div>
                        @endif
                        @if($banner->ends_at)
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">End Date</span>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $banner->ends_at->format('M d, Y H:i') }}</div>
                        </div>
                        @endif
                    </div>

                    @if($banner->description)
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $banner->description }}</p>
                        </div>
                    @endif

                    @if($banner->button_text && $banner->button_url)
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Button</h3>
                            <div class="space-y-1">
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Text:</span>
                                    <span class="text-gray-900 dark:text-gray-200 ml-2">{{ $banner->button_text }}</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">URL:</span>
                                    <a href="{{ $banner->button_url }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 ml-2">{{ $banner->button_url }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg mb-6 border border-gray-200 dark:border-gray-600">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Images</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Desktop Image</h3>
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" 
                             class="w-full h-32 object-cover rounded">
                    </div>

                    @if($banner->mobile_image_path)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mobile Image</h3>
                            <img src="{{ $banner->mobile_image_url }}" alt="{{ $banner->title }}" 
                                 class="w-full h-24 object-cover rounded">
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg border border-gray-200 dark:border-gray-600">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Actions</h2>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.banners.edit', $banner) }}" class="w-full bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Banner
                    </a>
                    
                    <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full {{ $banner->is_active ? 'bg-yellow-600 dark:bg-yellow-700 hover:bg-yellow-700 dark:hover:bg-yellow-600' : 'bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-600' }} text-white px-4 py-2 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $banner->is_active ? 'M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z' : 'M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z' }}"></path>
                            </svg>
                            {{ $banner->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 dark:bg-red-700 hover:bg-red-700 dark:hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center justify-center" onclick="return confirm('Are you sure you want to delete this banner? This action cannot be undone.')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Banner
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
