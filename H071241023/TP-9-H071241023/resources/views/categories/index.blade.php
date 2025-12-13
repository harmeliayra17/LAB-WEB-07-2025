@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold text-purple-200 mb-4">Daftar Kategori</h2>
<form method="get" class="mb-4 flex items-center gap-2">
    <div class="relative flex-1">
        <input type="text" 
            name="search"
            value="{{ $searchKeyword }}"
            placeholder="Cari nama…"
            class="w-full rounded-lg bg-white/10 border border-white/10 text-gray-100
                    pl-10 pr-20 py-2 placeholder-gray-400
                    focus:outline-none focus:ring-2 focus:ring-purple-400/60">
        <button type="submit"
            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-white">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <a href="{{ route('categories.index') }}"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-300 hover:text-white">
            <i class="fa-solid fa-rotate-right"></i>
        </a>
    </div>
    <a href="{{ route('categories.create') }}" 
        class="px-8 py-2 rounded-lg bg-purple-500/70 hover:bg-purple-500/90 text-white transition">
        + Tambah
    </a>
</form>

<div class="overflow-x-auto rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm">
    <table class="min-w-full text-xs sm:text-sm text-gray-100">
        <thead class="bg-purple-500/20 text-purple-100">
            <tr>
                <th class="text-left px-3 sm:px-4 py-2 sm:py-3 w-14">No</th>
                <th class="text-left px-3 sm:px-4 py-2 sm:py-3">Nama</th>
                <th class="text-left px-3 sm:px-4 py-2 sm:py-3">Deskripsi</th>
                <th class="text-left px-3 sm:px-4 py-2 sm:py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/10">
            @forelse($categories as $i => $category)
                <tr class="hover:bg-white/5 transition">
                    <td class="px-3 sm:px-4 py-2 sm:py-3 align-top">
                        {{ $categories->firstItem() + $i }}
                    </td>
                    <td class="px-3 sm:px-4 py-2 sm:py-3 align-top">
                        {{ $category->name }}
                    </td>
                    <td class="px-3 sm:px-4 py-2 sm:py-3 align-top">
                        {{ $category->description }}
                    </td>
                    <td class="px-3 sm:px-4 py-2 sm:py-3 align-top">
                        <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                            <a href="{{ route('categories.show',$category->id) }}" 
                                class="text-green-300 hover:underline">
                                Lihat
                            </a>
                            <span class="text-gray-500 hidden sm:inline">|</span>
                            <a href="{{ route('categories.edit',$category->id) }}" 
                                class="text-purple-300 hover:underline">
                                Edit
                            </a>
                            <span class="text-gray-500 hidden sm:inline">|</span>
                            <form action="{{ route('categories.destroy',$category->id) }}" method="post" 
                                    onsubmit="return confirm('hapus?')" class="inline">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-gray-300">
                        No data available.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $categories->links() }}
</div>
@endsection