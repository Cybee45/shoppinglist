@extends('layouts.app')

@section('title', 'Tambah Item Baru ke List')

@section('content')
<div class="container">
    <h2>Tambah Item Baru ke List: {{ $list->name ?? '' }}</h2>

    <form action="{{ route('items.storeTambah') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="list_id" value="{{ $list->id ?? old('list_id') }}">

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required min="1" value="1">
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" required min="0" step="any" value="0">
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="kategori" name="kategori" required>
                <option value="makanan">🥦 Makanan</option>
                <option value="minuman">🍹 Minuman</option>
                <option value="aktivitas">🏃 Aktivitas</option>
                <option value="barang lainnya">📦 Barang Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Barang (Opsional)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Item</button>
        <a href="{{ route('lists.show', $list->id) }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
