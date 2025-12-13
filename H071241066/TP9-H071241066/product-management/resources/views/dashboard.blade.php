@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <div class="breadcrumb-item active">
        <span>🏠</span>
        <span>Dashboard</span>
    </div>
@endsection

@section('content')
    <div class="page-header">
        <div class="page-title-row">
            <h1 class="page-title">
                <span class="page-title-icon">🏠</span>
                Dashboard
            </h1>
        </div>
        <p class="page-subtitle">Selamat datang di Sistem Manajemen Produk</p>
    </div>

    <div class="dashboard-grid">
        <a href="{{ route('products.index') }}" class="dashboard-card products">
            <div class="dashboard-card-header">
                <div class="dashboard-card-icon">📦</div>
            </div>
            <h3 class="dashboard-card-title">Manajemen Produk</h3>
            <p class="dashboard-card-description">Tambah, edit, hapus, dan lihat semua produk</p>
        </a>

        <a href="{{ route('stocks.index') }}" class="dashboard-card stocks">
            <div class="dashboard-card-header">
                <div class="dashboard-card-icon">📊</div>
            </div>
            <h3 class="dashboard-card-title">Manajemen Stok</h3>
            <p class="dashboard-card-description">Filter stok per gudang dan transfer stok</p>
        </a>

        <a href="{{ route('categories.index') }}" class="dashboard-card categories">
            <div class="dashboard-card-header">
                <div class="dashboard-card-icon">🏷️</div>
            </div>
            <h3 class="dashboard-card-title">Manajemen Kategori</h3>
            <p class="dashboard-card-description">Kelola semua daftar kategori produk</p>
        </a>

        <a href="{{ route('warehouses.index') }}" class="dashboard-card warehouses">
            <div class="dashboard-card-header">
                <div class="dashboard-card-icon">🏭</div>
            </div>
            <h3 class="dashboard-card-title">Manajemen Gudang</h3>
            <p class="dashboard-card-description">Kelola daftar lokasi dan nama gudang</p>
        </a>

        @if (Route::has('stocks.history'))
        <a href="{{ route('stocks.history') }}" class="dashboard-card stocks">
            <div class="dashboard-card-header">
                <div class="dashboard-card-icon">📜</div>
            </div>
            <h3 class="dashboard-card-title">Riwayat Stok</h3>
            <p class="dashboard-card-description">Lihat semua pergerakan stok secara global</p>
        </a>
        @endif
    </div>
@endsection