@extends('layouts.admin.layout')

@section('title', 'Edit Banner')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Edit Banner</h1>
        <a href="{{ route('admin.banners') }}" class="bg-gray-600 dark:bg-gray-700 hover:bg-gray-700 dark:hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Banners
        </a>
    </div>

    <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <x-tailwind.floating.text-input name="title" id="title" label="Title" type="text" :value="old('title', $banner->title)" required/>
                            @error('title')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-tailwind.floating.textarea name="description" label="Description" :value="old('description', $banner->description)" />
                            @error('description')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-tailwind.floating.text-input name="button_text" id="button_text" label="Button Text" type="text" :value="old('button_text', $banner->button_text)"/>
                                @error('button_text')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-tailwind.floating.text-input name="button_url" id="button_url" label="Button URL" type="url" :value="old('button_url', $banner->button_url)"/>
                                @error('button_url')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                @php
                                    $positions = [
                                        (object)['id' => 'home', 'name' => 'Home'],
                                        (object)['id' => 'category', 'name' => 'Category'],
                                        (object)['id' => 'product', 'name' => 'Product'],
                                    ];
                                @endphp
                                <x-tailwind.floating.dropdown name="position" label="Position" :listArray="$positions" listValue="id" listLabel="name" :value="old('position', $banner->position)" />
                                @error('position')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <x-tailwind.floating.text-input name="sort_order" id="sort_order" label="Sort Order" type="number" :value="old('sort_order', $banner->sort_order)" min="0"/>
                                @error('sort_order')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600 dark:text-blue-400" 
                                               name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700 dark:text-gray-300">Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-tailwind.floating.text-input name="starts_at" id="starts_at" label="Start Date" type="datetime-local" :value="old('starts_at', $banner->starts_at?->format('Y-m-d\TH:i'))"/>
                                @error('starts_at')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-tailwind.floating.text-input name="ends_at" id="ends_at" label="End Date" type="datetime-local" :value="old('ends_at', $banner->ends_at?->format('Y-m-d\TH:i'))"/>
                                @error('ends_at')
                                    <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Desktop Image</label>
                            <input type="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-800" 
                                   id="image" name="image" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Recommended: 1920x600px, Max 2MB</p>
                            @if($banner->image_path)
                                <div class="mt-2">
                                    <img src="{{ $banner->image_url }}" alt="Current image" 
                                         class="h-20 w-full object-cover rounded">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Current image</p>
                                </div>
                            @endif
                            @error('image')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mobile_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mobile Image</label>
                            <input type="file" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-800" 
                                   id="mobile_image" name="mobile_image" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Recommended: 768x400px, Max 2MB</p>
                            @if($banner->mobile_image_path)
                                <div class="mt-2">
                                    <img src="{{ $banner->mobile_image_url }}" alt="Current mobile image" 
                                         class="h-16 w-full object-cover rounded">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Current mobile image</p>
                                </div>
                            @endif
                            @error('mobile_image')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-400 dark:border-blue-500 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400 dark:text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Image Guidelines</h3>
                                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Desktop: 1920x600px (16:5 ratio)</li>
                                            <li>Mobile: 768x400px (16:8 ratio)</li>
                                            <li>Formats: JPG, PNG, GIF</li>
                                            <li>Max file size: 2MB</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.banners') }}" class="bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V2"></path>
                        </svg>
                        Update Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
