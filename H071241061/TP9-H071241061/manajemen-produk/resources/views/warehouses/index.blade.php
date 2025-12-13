@extends('layouts.app')
@section('title', 'Daftar Gudang')
@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-pink-700">Gudang</h1>
            <p class="mt-1 text-sm text-pink-500">Kelola lokasi penyimpanan produk kamu 💫</p>
        </div>
        <a href="{{ route('warehouses.create') }}"
           class="inline-flex items-center px-5 py-2.5 bg-pink-500 hover:bg-pink-600 text-white font-semibold rounded-full shadow-md transition-all duration-300 transform hover:scale-105 hover:shadow-pink-200">
            <i class="fas fa-plus mr-2"></i>Tambah Gudang
        </a>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-md border border-pink-100 p-5">
        <form method="GET" action="{{ route('warehouses.index') }}">
            <div class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari gudang..."
                    class="flex-1 px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 placeholder-pink-300 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:outline-none transition-all duration-200">
                <button type="submit"
                        class="px-5 py-2 bg-pink-500 hover:bg-pink-600 text-white font-medium rounded-xl shadow-sm transition-all duration-200 hover:shadow-md">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                <a href="{{ route('warehouses.index') }}"
                   class="px-4 py-2 bg-pink-100 hover:bg-pink-200 text-pink-700 font-medium rounded-xl transition-all duration-200">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-lg overflow-hidden border border-pink-100">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-pink-100/60">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase tracking-wider">Nama Gudang</th>
                        <th class="px-6 py-3 font-semibold text-pink-700 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 font-semibold text-right text-pink-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-50">
                    @forelse($warehouses as $warehouse)
                    <tr class="hover:bg-pink-50 transition-all duration-200">
                        <td class="px-6 py-4 text-gray-600">{{ ($warehouses->currentPage() - 1) * $warehouses->perPage() + $loop->iteration }}</td>
                        <td class="px-6 py-4 flex items-center">
                            <div class="h-10 w-10 bg-pink-100 text-pink-600 flex items-center justify-center rounded-full shadow-sm">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <span class="ml-3 font-medium text-gray-800">{{ $warehouse->name }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 max-w-md truncate">
                            {{ $warehouse->location ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-3">
                            <a href="{{ route('warehouses.show', $warehouse) }}" class="text-pink-600 hover:text-pink-800 transition-all"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('warehouses.edit', $warehouse) }}" class="text-amber-500 hover:text-amber-600 transition-all"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus gudang ini? 😢')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-all"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-pink-600">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-warehouse text-pink-300 text-5xl mb-3"></i>
                                <p class="text-lg font-medium">Belum ada gudang ditemukan</p>
                                <a href="{{ route('warehouses.create') }}" class="mt-3 text-pink-600 hover:text-pink-800 font-semibold">
                                    Tambah gudang pertama ✨
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($warehouses->hasPages())
        <div class="bg-pink-50/60 px-4 py-3 border-t border-pink-100 sm:px-6">
            {{ $warehouses->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
