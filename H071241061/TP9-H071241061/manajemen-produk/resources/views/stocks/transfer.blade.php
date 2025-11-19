@extends('layouts.app')
@section('title', 'Transfer Stok')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-pink-700">Transfer Stok</h1>
        <p class="mt-1 text-sm text-pink-400">Tambah atau kurangi stok produk di gudang 📦</p>
    </div>

    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-md p-6 border border-pink-100">
        <form action="{{ route('stocks.store') }}" method="POST" class="space-y-6" id="transferForm">
            @csrf

            <!-- Pilih Gudang -->
            <div>
                <label for="warehouse_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Gudang <span class="text-red-500">*</span>
                </label>
                <select name="warehouse_id" id="warehouse_id" required
                    class="w-full px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent @error('warehouse_id') border-red-500 @enderror">
                    <option value="">Pilih Gudang...</option>
                    @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                        {{ $warehouse->name }} - {{ $warehouse->location }}
                    </option>
                    @endforeach
                </select>
                @error('warehouse_id')
                <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pilih Produk -->
            <div>
                <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Produk <span class="text-red-500">*</span>
                </label>
                <select name="product_id" id="product_id" required
                    class="w-full px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent @error('product_id') border-red-500 @enderror">
                    <option value="">Pilih Produk...</option>
                    @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} 
                        @if($product->category)
                        ({{ $product->category->name }})
                        @endif
                    </option>
                    @endforeach
                </select>
                @error('product_id')
                <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah Transfer -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" required
                        class="w-full px-4 py-2 border border-pink-200 rounded-xl bg-pink-50/40 text-gray-700 focus:ring-2 focus:ring-pink-400 focus:border-transparent @error('quantity') border-red-500 @enderror"
                        placeholder="Masukkan jumlah (positif untuk tambah, negatif untuk kurang)"
                        min="-9999"
                        step="1">
                    <div class="absolute right-3 top-2 text-gray-400 text-sm">
                        unit
                    </div>
                </div>
                @error('quantity')
                <p class="mt-1 text-sm text-red-500 italic">{{ $message }}</p>
                @enderror
                <div class="mt-2 p-3 bg-pink-50 rounded-lg">
                    <p class="text-xs text-pink-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        <strong>Tips:</strong> Gunakan angka positif untuk menambah stok, angka negatif untuk mengurangi stok.
                    </p>
                    <p class="text-xs text-pink-600 mt-1">
                        Contoh: <code class="bg-pink-100 px-1 rounded">+50</code> untuk tambah 50 unit, 
                        <code class="bg-pink-100 px-1 rounded">-20</code> untuk kurang 20 unit
                    </p>
                </div>
            </div>

            <!-- Preview Section -->
            <div id="previewSection" class="hidden p-4 bg-gradient-to-r from-pink-50 to-pink-100 rounded-xl border border-pink-200">
                <h4 class="font-semibold text-pink-700 mb-3">
                    <i class="fas fa-eye mr-2"></i>Preview Transfer
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Gudang:</span>
                        <span class="font-medium text-gray-900" id="previewWarehouse">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Produk:</span>
                        <span class="font-medium text-gray-900" id="previewProduct">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah:</span>
                        <span class="font-bold" id="previewQuantity">-</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-pink-200">
                        <span class="text-gray-600">Aksi:</span>
                        <span class="font-semibold" id="previewAction">-</span>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4 border-t border-pink-100">
                <button type="submit"
                    class="flex-1 bg-pink-500 hover:bg-pink-600 text-white font-semibold py-3 px-4 rounded-2xl shadow-md transition-all duration-200 transform hover:scale-105 hover:shadow-pink-200">
                    <i class="fas fa-check mr-2"></i>Transfer Stok
                </button>
                <a href="{{ route('stocks.index') }}"
                    class="flex-1 bg-pink-100 hover:bg-pink-200 text-pink-700 font-semibold py-3 px-4 rounded-2xl text-center transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Info Box -->
    <div class="mt-6 p-5 bg-pink-50/80 backdrop-blur-sm rounded-2xl border border-pink-200">
        <h3 class="font-semibold text-pink-700 mb-3">
            <i class="fas fa-lightbulb mr-2"></i>Cara Menggunakan Transfer Stok
        </h3>
        <ul class="space-y-2 text-sm text-gray-700">
            <li class="flex items-start">
                <i class="fas fa-check-circle text-pink-500 mt-1 mr-2"></i>
                <span>Pilih gudang tujuan dan produk yang ingin ditransfer</span>
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle text-pink-500 mt-1 mr-2"></i>
                <span>Masukkan jumlah: <strong>positif (+)</strong> untuk menambah stok, <strong>negatif (-)</strong> untuk mengurangi stok</span>
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle text-pink-500 mt-1 mr-2"></i>
                <span>Sistem akan otomatis validasi agar stok tidak menjadi minus</span>
            </li>
        </ul>
    </div>
</div>

<script>
// Preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const warehouseSelect = document.getElementById('warehouse_id');
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const previewSection = document.getElementById('previewSection');

    function updatePreview() {
        const warehouse = warehouseSelect.options[warehouseSelect.selectedIndex];
        const product = productSelect.options[productSelect.selectedIndex];
        const quantity = parseInt(quantityInput.value) || 0;

        if (warehouseSelect.value && productSelect.value && quantity !== 0) {
            previewSection.classList.remove('hidden');
            
            document.getElementById('previewWarehouse').textContent = warehouse.text;
            document.getElementById('previewProduct').textContent = product.text;
            
            const quantityEl = document.getElementById('previewQuantity');
            const actionEl = document.getElementById('previewAction');
            
            if (quantity > 0) {
                quantityEl.textContent = '+' + quantity + ' unit';
                quantityEl.className = 'font-bold text-green-600';
                actionEl.textContent = 'Menambah Stok';
                actionEl.className = 'font-semibold text-green-600';
            } else {
                quantityEl.textContent = quantity + ' unit';
                quantityEl.className = 'font-bold text-red-600';
                actionEl.textContent = 'Mengurangi Stok';
                actionEl.className = 'font-semibold text-red-600';
            }
        } else {
            previewSection.classList.add('hidden');
        }
    }

    warehouseSelect.addEventListener('change', updatePreview);
    productSelect.addEventListener('change', updatePreview);
    quantityInput.addEventListener('input', updatePreview);
});
</script>
@endsection