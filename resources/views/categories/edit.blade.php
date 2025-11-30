<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

                {{-- HEADER HALAMAN --}}
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            {{ __('Edit Category') }}
                        </h2>
                        <p class="text-gray-400 text-sm mt-2">Update category details.</p>
                    </div>
                </div>

                {{-- CARD FORM (GELAP) --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">

                    <div class="px-8 py-6 border-b border-[#2D3748] bg-[#151B2D] flex justify-between items-center">
                        <h3 class="text-xl font-black text-white">Edit: {{ $category->name }}</h3>
                    </div>

                    <div class="p-8">
                        <form method="POST" action="{{ route('categories.update', $category) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">

                                {{-- Nama Kategori --}}
                                <div>
                                    <x-input-label for="name" :value="__('Category Name')"
                                        class="font-bold !text-gray-300" />
                                    <input id="name"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                        type="text" name="name" value="{{ old('name', $category->name) }}" required />
                                    @error('name') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <x-input-label for="description" :value="__('Description')"
                                        class="font-bold !text-gray-300" />
                                    <textarea id="description" name="description"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                                        rows="3">{{ old('description', $category->description) }}</textarea>
                                    @error('description') <p class="text-red-500 text-xs mt-1 font-medium">
                                    {{ $message }}</p> @enderror
                                </div>

                                {{-- Gambar --}}    
                                <div>
                                    <x-input-label for="image_path" :value="__('Category Image')"
                                        class="font-bold !text-gray-300" />

                                    {{-- Preview Gambar Lama --}}
                                    @if($category->image_path)
                                        <div
                                            class="my-3 flex items-center p-3 bg-[#1A202C] rounded-lg border border-[#2D3748] w-fit">
                                            <img src="{{ Storage::url($category->image_path) }}"
                                                class="h-16 w-16 rounded-lg object-cover border border-[#4A5568]">
                                            <div class="ml-3">
                                                <span
                                                    class="text-xs text-gray-500 block uppercase tracking-wider font-bold">Current
                                                    Image</span>
                                                <span class="text-xs text-gray-400">Upload new to replace</span>
                                            </div>
                                        </div>
                                    @endif

                                    <input id="image_path" type="file" name="image_path"
                                        class="block w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition border border-[#4A5568] rounded-lg cursor-pointer bg-[#2D3748] focus:outline-none" />
                                    @error('image_path') <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}
                                    </p> @enderror
                                </div>

                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-[#2D3748]">
                                <a href="{{ route('categories.index') }}"
                                    class="px-6 py-2.5 text-sm font-bold text-gray-300 bg-[#1F2937] border border-[#4A5568] rounded-lg hover:bg-[#374151] hover:text-white transition shadow-sm">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-[#151B2D] transition-all transform hover:-translate-y-0.5">
                                    Update Category
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>