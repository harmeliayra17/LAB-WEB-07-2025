@extends('layouts.app')

@section('title', 'Database Ikan - Fish It Simulator')

@section('styles')
<style>
    .filter-section {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .form-select {
        padding: 0.7rem 1rem;
        border: 2px solid #1a237e;
        border-radius: 6px;
        font-size: 1rem;
        background: white;
        cursor: pointer;
    }

    .table-container {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .table thead {
        background: #1a237e;
        color: white;
    }

    .table th,
    .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    .table tbody tr {
        transition: background 0.2s;
    }

    .table tbody tr:hover {
        background: #f5f5f5;
    }

    .badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }

    .badge-common { background: #9e9e9e; color: white; }
    .badge-uncommon { background: #4caf50; color: white; }
    .badge-rare { background: #2196f3; color: white; }
    .badge-epic { background: #9c27b0; color: white; }
    .badge-legendary { background: #ff9800; color: white; }
    .badge-mythic { background: #f44336; color: white; }
    .badge-secret { background: #000000; color: #ffd700; }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        flex-wrap: wrap;
        gap: 1rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .pagination-info {
        color: #495057;
        font-size: 0.95rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination-info span {
        background: #1a237e;
        color: white;
        padding: 0.3rem 0.7rem;
        border-radius: 6px;
        font-weight: 700;
    }

    .pagination-controls {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .pagination-btn {
        padding: 0.7rem 1.5rem;
        border: 2px solid #1a237e;
        border-radius: 8px;
        text-decoration: none;
        color: #1a237e;
        background: white;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 120px;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(26, 35, 126, 0.1);
    }

    .pagination-btn:hover:not(.disabled) {
        background: #1a237e;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(26, 35, 126, 0.3);
    }

    .pagination-btn.disabled {
        background: #e9ecef;
        color: #adb5bd;
        border-color: #dee2e6;
        cursor: not-allowed;
        pointer-events: none;
        box-shadow: none;
    }

    .pagination-btn::before {
        font-size: 1.2rem;
    }

    .pagination-btn.prev::before {
        content: "«";
    }

    .pagination-btn.next::after {
        content: "»";
    }



    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #666;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .pagination-controls {
            flex-direction: column;
            width: 100%;
        }

        .pagination-btn {
            width: 100%;
        }

        .page-numbers {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <div class="header-actions">
            <h1 class="card-title">Database Ikan</h1>
        </div>
    </div>

    <div class="filter-section">
        <form method="GET" action="{{ route('fishes.index') }}" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap; width: 100%;">
            <div style="flex: 1; min-width: 250px;">
                <label for="search" style="display: block; margin-bottom: 0.3rem; font-weight: 600;">Cari Nama Ikan:</label>
                <input type="text" name="search" id="search" placeholder="Ketik nama ikan" 
                       class="form-select" value="{{ request('search') }}" style="width: 100%;">
            </div>

            <div style="min-width: 180px;">
                <label for="rarity" style="display: block; margin-bottom: 0.3rem; font-weight: 600;">Filter Rarity:</label>
                <select name="rarity" id="rarity" class="form-select">
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

            <div style="min-width: 200px;">
                <label for="sort" style="display: block; margin-bottom: 0.3rem; font-weight: 600;">Urutkan Berdasarkan:</label>
                <select name="sort" id="sort" class="form-select">
                    <option value="">-- Pilih Urutan --</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga (Termurah)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga (Termahal)</option>
                    <option value="probability_asc" {{ request('sort') == 'probability_asc' ? 'selected' : '' }}>Probabilitas (Terendah)</option>
                    <option value="probability_desc" {{ request('sort') == 'probability_desc' ? 'selected' : '' }}>Probabilitas (Tertinggi)</option>
                </select>
            </div>

            <div style="display: flex; gap: 0.5rem; align-items: flex-end; margin-top: 1.55rem;">
                <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
                @if(request('search') || request('rarity') || request('sort'))
                    <a href="{{ route('fishes.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                @endif
            </div>
        </form>
    </div>

    @if($fishes->count() > 0)
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Ikan</th>
                    <th>Rarity</th>
                    <th>Rentang Berat</th>
                    <th>Harga/kg</th>
                    <th>Peluang Tangkap</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($fishes as $fish)
                <tr>
                    <td><strong>{{ $fish->name }}</strong></td>
                    <td>
                    <span class="badge {{ $fish->rarity_badge_class }}">
                        {{ $fish->rarity }}
                    </span>
                    </td>
                    <td>{{ $fish->formatted_weight }}</td>
                    <td>{{ $fish->formatted_price }}</td>
                    <td>{{ $fish->formatted_probability }}</td>

                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('fishes.show', $fish->id) }}" class="btn btn-primary btn-sm">Detail</a>
                            <a href="{{ route('fishes.edit', $fish->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('fishes.destroy', $fish->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($fishes->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan <span>{{ $fishes->firstItem() }}</span> - <span>{{ $fishes->lastItem() }}</span> dari <span>{{ $fishes->total() }}</span> ikan
        </div>

        <div class="pagination-controls">
            {{-- Previous Button --}}
            @if ($fishes->onFirstPage())
                <span class="pagination-btn prev disabled">Sebelumnya</span>
            @else
                <a href="{{ $fishes->appends(request()->query())->previousPageUrl() }}" class="pagination-btn prev">Sebelumnya</a>
            @endif

            {{-- Next Button --}}
            @if ($fishes->hasMorePages())
                <a href="{{ $fishes->appends(request()->query())->nextPageUrl() }}" class="pagination-btn next">Selanjutnya</a>
            @else
                <span class="pagination-btn next disabled">Selanjutnya</span>
            @endif
        </div>
    </div>
    @endif

    @else
    <div class="empty-state">
        <h3>🐟 Belum Ada Ikan</h3>
        <p>Database masih kosong. Tambahkan ikan pertama Anda!</p>
        <a href="{{ route('fishes.create') }}" class="btn btn-primary" style="margin-top: 1rem;">Tambah Ikan Sekarang</a>
    </div>
    @endif
</div>
@endsection