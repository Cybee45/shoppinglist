@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontsite/style/create.css') }}">
@endpush

@section('title', 'Tambah Item Baru ke List')

@section('content')
<div class="container">
    <h2 class="mb-5">
        <i class="fa-solid fa-cart-plus text-warning me-3"></i> 
        Tambah Item Baru ke List: {{ $list->name ?? '' }}
    </h2>

    <form action="{{ route('items.storeTambah') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="list_id" value="{{ $list->id ?? old('list_id') }}">

        <div class="mb-3">
            <label for="nama_barang" class="form-label">
                <i class="fa-solid fa-box-open me-2 text-warning"></i> Nama Barang
            </label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">
                <i class="fa-solid fa-list-ol me-2 text-warning"></i> Jumlah
            </label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required min="1" value="1">
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">
                <i class="fa-solid fa-tags me-2 text-warning"></i> Harga
            </label>
            <input type="number" class="form-control" id="harga" name="harga" required min="0" step="any" value="0">
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">
                <i class="fa-solid fa-layer-group me-2 text-warning"></i> Kategori
            </label>
            <select class="form-select" id="kategori" name="kategori" required>
                <option value="makanan">🥦 Makanan</option>
                <option value="minuman">🍹 Minuman</option>
                <option value="aktivitas">🏃 Aktivitas</option>
                <option value="barang lainnya">📦 Barang Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">
                <i class="fa-solid fa-image me-2 text-warning"></i> Gambar Barang (Opsional)
            </label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk me-1"></i> Simpan Item
        </button>
        <a href="{{ route('lists.show', $list->id) }}" class="btn btn-secondary">
            <i class="fa-solid fa-ban me-1"></i> Batal
        </a>
    </form>
</div>
@endsection