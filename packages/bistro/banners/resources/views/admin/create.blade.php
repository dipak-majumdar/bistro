@extends('layouts.admin.layout')

@section('title', 'Create Banner')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Create Banner</h1>
        <a href="{{ route('admin.banners') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Banners
        </a>
    </div>

    <div class="border border-gray-200 rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <x-tailwind.floating.text-input name="title" id="title" label="Title" type="text" required/>
                            @error('title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-tailwind.floating.textarea name="description" label="Description" />
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-tailwind.floating.text-input name="button_text" id="button_text" label="Button Text" type="text" required/>
                                @error('button_text')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-tailwind.floating.text-input name="button_url" id="button_url" label="Button URL" type="url" required/>
                                @error('button_url')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                @php
                                    $positions = [
                                        (object)['id' => 1, 'name' => 'Home'],
                                        (object)['id' => 2, 'name' => 'Category'],
                                        (object)['id' => 3, 'name' => 'Product'],
                                    ];
                                @endphp
                                <x-tailwind.floating.dropdown name="position" label="Position" :listArray="$positions" listValue="id" listLabel="name" />
                                @error('position')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <x-tailwind.floating.text-input name="sort_order" id="sort_order" label="Sort Order" type="number" required min="0"/>
                                @error('sort_order')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" 
                                               name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <span class="ml-2 text-gray-700">Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-tailwind.floating.text-input name="starts_at" id="starts_at" label="Start Date" type="datetime-local" required/>
                                @error('starts_at')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-tailwind.floating.text-input name="ends_at" id="ends_at" label="End Date" type="datetime-local" required/>
                                @error('ends_at')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Desktop Image *</label>
                            <input type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                                   id="image" name="image" accept="image/*" required>
                            <p class="mt-1 text-sm text-gray-500">Recommended: 1920x600px, Max 2MB</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mobile_image" class="block text-sm font-medium text-gray-700">Mobile Image</label>
                            <input type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                                   id="mobile_image" name="mobile_image" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">Recommended: 768x400px, Max 2MB</p>
                            @error('mobile_image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-blue-800">Image Guidelines</h3>
                                    <div class="mt-2 text-sm text-blue-700">
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
                    <a href="{{ route('admin.banners') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">Cancel</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V2"></path>
                        </svg>
                        Create Banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
