@extends('layouts.app')

@section('title', $fish->name . ' - Fish It Simulator')

@section('styles')
<style>
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .detail-section {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        border-left: 4px solid #1a237e;
    }

    .detail-label {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 1.3rem;
        font-weight: bold;
        color: #1a237e;
    }

    .detail-value.highlight {
        color: #f57c00;
    }

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 1rem;
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

    .probability-bar {
        width: 100%;
        height: 30px;
        background: #e0e0e0;
        border-radius: 15px;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .probability-fill {
        height: 100%;
        background: #00bcd4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.9rem;
        transition: width 0.5s ease;
    }

    .description-box {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        border-left: 4px solid #1a237e;
    }

    .description-box h3 {
        color: #1a237e;
        margin-bottom: 1rem;
    }

    .description-box p {
        color: #666;
        line-height: 1.6;
        font-style: italic;
    }

    .stats-box {
        background: #e3f2fd;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .stats-title {
        color: #1a237e;
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 1rem;
        text-align: center;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        text-align: center;
    }

    .stat-item {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        border: 2px solid #1a237e;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #1a237e;
    }

    .stat-value.coins {
        color: #f57c00;
    }

    .action-section {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .timestamp {
        text-align: center;
        color: #666;
        font-size: 0.9rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #e0e0e0;
    }

    .accessor-demo {
        background: #fff3e0;
        padding: 1.5rem;
        border-radius: 8px;
        border-left: 4px solid #f57c00;
        margin-bottom: 2rem;
    }

    .accessor-demo h3 {
        color: #f57c00;
        margin-bottom: 1rem;
    }

    .accessor-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .accessor-item {
        background: white;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #ffe0b2;
    }

    .accessor-item strong {
        display: block;
        color: #f57c00;
        font-size: 0.85rem;
        margin-bottom: 0.3rem;
    }

    .accessor-item span {
        color: #333;
        font-size: 1rem;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
        .stats-row {
            grid-template-columns: 1fr;
        }
        .accessor-list {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">{{ $fish->name }}</h1>
    </div>

    <div class="detail-grid">
        <div class="detail-section">
            <div class="detail-label">Rarity</div>
            <div class="detail-value">
                <span class="badge {{ $fish->rarity_badge_class }}">
                    {{ $fish->rarity }}
                </span>
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-label">Rentang Berat</div>
            <div class="detail-value">{{ $fish->formatted_weight }}</div>
            <div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">
                Rata-rata: {{ $fish->average_weight}}
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-label">Harga Jual per kg</div>
            <div class="detail-value highlight">{{ $fish->formatted_price }}</div>
        </div>

        <div class="detail-section">
            <div class="detail-label">Peluang Tertangkap</div>
            <div class="detail-value">
                {{ $fish->formatted_probability }}
            </div>
            <div class="probability-bar">
                <div class="probability-fill" style="width: {{ min($fish->catch_probability, 100) }}%">
                    {{ $fish->formatted_probability }}
                </div>
            </div>
        </div>
    </div>

    <div class="description-box">
        <h3>Deskripsi</h3>
        @if($fish->description)
            <p>{{ $fish->description }}</p>
        @else
            <p>Tidak ada deskripsi</p>
        @endif
    </div>

    <div class="action-section">
        <a href="{{ route('fishes.edit', $fish->id) }}" class="btn btn-warning">Edit Ikan</a>
        <form action="{{ route('fishes.destroy', $fish->id) }}" method="POST" style="display: inline;" 
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus ikan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus Ikan</button>
        </form>
        <a href="{{ route('fishes.index') }}" class="btn btn-secondary">← Kembali ke Database</a>
    </div>

    <div class="timestamp">
    <p>Dibuat: {{ $fish->created_at }}</p>
    <p>Update terakhir: {{ $fish->updated_at }}</p>
    </div>
</div>
@endsection