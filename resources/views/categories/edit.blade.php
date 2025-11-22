<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-900 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden border border-gray-100">
                
                <div class="px-8 py-6 border-b border-gray-100 bg-white flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Edit: {{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">Update category details.</p>
                    </div>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('categories.update', $category) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            
                            {{-- Nama Kategori --}}
                            <div>
                                <x-input-label for="name" :value="__('Category Name')" class="font-bold text-gray-700" />
                                <input id="name" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm py-2.5" type="text" name="name" value="{{ old('name', $category->name) }}" required />
                                @error('name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div>
                                <x-input-label for="description" :value="__('Description')" class="font-bold text-gray-700" />
                                <textarea id="description" name="description" class="block mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" rows="3">{{ old('description', $category->description) }}</textarea>
                                @error('description') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                            {{-- Gambar --}}
                            <div>
                                <x-input-label for="image_path" :value="__('Category Image')" class="font-bold text-gray-700" />
                                
                                {{-- Preview Gambar Lama --}}
                                @if($category->image_path)
                                    <div class="my-3 flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 w-fit">
                                        <img src="{{ Storage::url($category->image_path) }}" class="h-16 w-16 rounded-lg object-cover border">
                                        <span class="ml-3 text-sm text-gray-500">Current Image</span>
                                    </div>
                                @endif

                                <input id="image_path" type="file" name="image_path" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition border border-gray-300 rounded-lg bg-gray-50" />
                                @error('image_path') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>

                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('categories.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">Cancel</a>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all transform hover:-translate-y-0.5">Update Category</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>