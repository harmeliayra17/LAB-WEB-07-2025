@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Daftar Ikan</h1>

    <form method="GET" class="mb-6 bg-white p-4 rounded-lg shadow">
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="w-full md:w-1/4">
                <label for="rarity" class="block text-sm font-medium text-gray-700 mb-1">Rarity</label>
                <select name="rarity" id="rarity" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm">
                    <option value="">Semua Rarity</option>
                    <option value="Common" {{ request('rarity') == 'Common' ? 'selected' : '' }}>Common</option>
                    <option value="Uncommon" {{ request('rarity') == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                    <option value="Rare" {{ request('rarity') == 'Rare' ? 'selected' : '' }}>Rare</option>
                    <option value="Epic" {{ request('rarity') == 'Epic' ? 'selected' : '' }}>Epic</option>
                    <option value="Legendary" {{ request('rarity') == 'Legendary' ? 'selected' : '' }}>Legendary</option>
                    <option value="Mythic" {{ request('rarity') == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                    <option value="Secret" {{ request('rarity') == 'Secret' ? 'selected' : '' }}>Secret</option>
                </select>
            </div>
            <div class="w-full md:w-1/4">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Ikan</label>
                <input type="text" name="search" id="search" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2" placeholder="Cari nama ikan" value="{{ request('search') }}">
            </div>
            <div class="w-full md:w-auto">
                <button type="submit" class="w-full md:w-auto px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Filter
                </button>
            </div>
        </div>
    </form>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    @php
                                        $sort = 'name';
                                        $direction = request('direction', 'asc');
                                        $isCurrentSort = request('sort') == $sort;
                                        $nextDirection = $isCurrentSort && $direction == 'asc' ? 'desc' : 'asc';
                                    @endphp
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => $sort, 'direction' => $nextDirection]) }}" class="flex items-center hover:text-gray-900">
                                        Nama
                                        @if ($isCurrentSort)
                                            <span class="ml-1 text-xs">
                                                @if ($direction == 'asc')
                                                    &#x25B2; @else
                                                    &#x25BC; @endif
                                            </span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rarity
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Berat
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    @php
                                        $sort = 'price';
                                        $direction = request('direction', 'asc');
                                        $isCurrentSort = request('sort') == $sort;
                                        $nextDirection = $isCurrentSort && $direction == 'asc' ? 'desc' : 'asc';
                                    @endphp
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => $sort, 'direction' => $nextDirection]) }}" class="flex items-center hover:text-gray-900">
                                        Harga Jual
                                        @if ($isCurrentSort)
                                            <span class="ml-1 text-xs">
                                                @if ($direction == 'asc')
                                                    &#x25B2; @else
                                                    &#x25BC; @endif
                                            </span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    @php
                                        $sort = 'probability';
                                        $direction = request('direction', 'asc');
                                        $isCurrentSort = request('sort') == $sort;
                                        $nextDirection = $isCurrentSort && $direction == 'asc' ? 'desc' : 'asc';
                                    @endphp
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => $sort, 'direction' => $nextDirection]) }}" class="flex items-center hover:text-gray-900">
                                        Probabilitas
                                        @if ($isCurrentSort)
                                            <span class="ml-1 text-xs">
                                                @if ($direction == 'asc')
                                                    &#x25B2; @else
                                                    &#x25BC; @endif
                                            </span>
                                        @endif
                                    </a>
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($fishes as $fish)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $fish->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fish->rarity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fish->formatted_weight }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fish->formatted_price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $fish->formatted_probability }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex space-x-2 justify-end">
                                            <a href="{{ route('fishes.show', $fish) }}" class="text-indigo-600 hover:text-indigo-900 p-1 rounded-md bg-indigo-100 hover:bg-indigo-200 transition duration-150 ease-in-out">Detail</a>
                                            <a href="{{ route('fishes.edit', $fish) }}" class="text-yellow-600 hover:text-yellow-900 p-1 rounded-md bg-yellow-100 hover:bg-yellow-200 transition duration-150 ease-in-out">Edit</a>
                                            <form action="{{ route('fishes.destroy', $fish) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded-md bg-red-100 hover:bg-red-200 transition duration-150 ease-in-out">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $fishes->links() }}
    </div>
@endsection