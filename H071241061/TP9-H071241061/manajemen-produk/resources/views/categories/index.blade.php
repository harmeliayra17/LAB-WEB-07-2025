@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-pink-700">Kategori Produk</h1>
            <p class="mt-1 text-sm text-pink-500">Kelola kategori produk dengan mudah 💫</p>
        </div>
        <a href="{{ route('categories.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-full shadow-md transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
            <i class="fas fa-plus mr-2"></i> Tambah Kategori
        </a>
    </div>

    <!-- Search Bar -->
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-5 border border-pink-100">
        <form method="GET" action="{{ route('categories.index') }}">
            <div class="flex gap-3 items-center">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="🔍 Cari kategori..." 
                    class="flex-1 px-4 py-2 border border-pink-200 rounded-xl focus:ring-2 focus:ring-pink-400 focus:outline-none placeholder-pink-300 text-gray-700">
                <button type="submit" 
                        class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                <a href="{{ route('categories.index') }}" 
                   class="px-4 py-2 bg-pink-100 hover:bg-pink-200 text-pink-600 font-medium rounded-xl transition-all duration-200">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg overflow-hidden border border-pink-100">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-pink-100/60">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase tracking-wider">Jumlah Produk</th>
                        <th class="px-6 py-3 font-semibold text-right text-pink-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-50">
                    @forelse($categories as $category)
                    <tr class="hover:bg-pink-50 transition-all duration-200">
                        <td class="px-6 py-4 text-gray-600">
                            {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 flex items-center">
                            <div class="h-10 w-10 bg-pink-100 text-pink-600 flex items-center justify-center rounded-full shadow-sm">
                                <i class="fas fa-tag"></i>
                            </div>
                            <span class="ml-3 font-medium text-gray-800">{{ $category->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 max-w-xs truncate">
                            {{ $category->description ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-700">
                                {{ $category->products_count }} Produk
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('categories.show', $category) }}" 
                               class="text-pink-600 hover:text-pink-800 transition-all duration-200">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('categories.edit', $category) }}" 
                               class="text-amber-500 hover:text-amber-600 transition-all duration-200">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" 
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini? 😢')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-all duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-pink-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-pink-300 text-5xl mb-4"></i>
                                <p class="text-lg font-medium">Belum ada kategori</p>
                                <a href="{{ route('categories.create') }}" 
                                   class="mt-3 text-pink-600 hover:text-pink-800 font-semibold transition-all">
                                    Tambah kategori pertama ✨
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="bg-pink-50/60 px-4 py-3 border-t border-pink-100 sm:px-6">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
