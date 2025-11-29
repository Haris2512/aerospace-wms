<x-app-layout>
    <div class="min-h-screen bg-[#0B1120] text-gray-300 font-sans">

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

                {{-- HEADER --}}
                <div class="mb-8 flex justify-between items-center">
                    <div>
                        <h2 class="font-bold text-3xl text-white leading-tight">
                            {{ __('Add New Category') }}
                        </h2>
                        <p class="text-gray-400 text-sm mt-2">Create a new category to organize components.</p>
                    </div>
                </div>

                {{-- CARD FORM --}}
                <div class="bg-[#151B2D] shadow-2xl sm:rounded-2xl overflow-hidden border border-[#2D3748]">

                    {{-- Header Card --}}
                    <div class="px-8 py-6 border-b border-[#2D3748] bg-[#151B2D]">
                        <h3 class="text-xl font-black text-white">Category Details</h3>
                        <p class="text-sm text-gray-400 mt-1">Fill in the information below.</p>
                    </div>

                    <div class="p-8">
                        {{-- Form Tambah Kategori --}}
                        <form method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="space-y-6">
                                {{-- Nama Kategori --}}
                                <div>
                                    <x-input-label for="name" :value="__('Category Name')"
                                        class="font-bold !text-gray-300" />
                                    <input id="name"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm py-2.5"
                                        type="text" name="name" value="{{ old('name') }}" required autofocus
                                        placeholder="e.g. Avionics, Engine Parts" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <x-input-label for="description" :value="__('Description (Optional)')"
                                        class="font-bold !text-gray-300" />
                                    <textarea id="description" name="description"
                                        class="block mt-2 w-full rounded-lg border-[#4A5568] bg-[#2D3748] text-white placeholder-gray-500 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                                        rows="4"
                                        placeholder="Describe this category...">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                {{-- Upload Gambar --}}
                                <div>
                                    <x-input-label for="image_path" :value="__('Category Image')"
                                        class="font-bold !text-gray-300" />
                                    <div class="mt-2 flex items-center">
                                        <input id="image_path" type="file" name="image_path"
                                            class="block w-full text-sm text-gray-400
                                            file:mr-4 file:py-2.5 file:px-4
                                            file:rounded-lg file:border-0
                                            file:text-sm file:font-bold
                                            file:bg-blue-600 file:text-white
                                            hover:file:bg-blue-700 transition
                                            border border-[#4A5568] rounded-lg cursor-pointer bg-[#2D3748] focus:outline-none" />
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">Recommended: Square image (JPG, PNG).</p>
                                    <x-input-error :messages="$errors->get('image_path')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Tombol Simpan & Batal --}}
                            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-[#2D3748]">
                                <a href="{{ route('categories.index') }}"
                                    class="px-6 py-2.5 text-sm font-bold text-gray-300 bg-[#1F2937] border border-[#4A5568] rounded-lg hover:bg-[#374151] hover:text-white transition shadow-sm">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-lg shadow-lg shadow-blue-500/20 transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-[#151B2D]">
                                    Save Category
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>