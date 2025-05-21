@extends('layouts.app')

@section('head')
    <link href="{{ asset('Frontsite/style/create.css') }}" rel="stylesheet" />
    @if (session('success'))
        <script>
            window.STANDARD_SUCCESS_MESSAGE = @json(session('success'));
        </script>
    @endif
@endsection

@section('content')
<div class="container form-container">
    <h3 class="title mb-4">Edit Barang: {{ $item->nama_barang }}</h3>

    <form method="POST" action="{{ route('items.update', $item->id) }}" enctype="multipart/form-data" class="form-modern" id="editItemForm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label"><i class="fa-solid fa-box"></i> Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $item->nama_barang) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fa-solid fa-list-ol"></i> Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $item->jumlah) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fa-solid fa-dollar-sign"></i> Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ old('harga', $item->harga) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label"><i class="fa-solid fa-tags"></i> Kategori</label>
            <select name="kategori" class="form-select" required>
                <option value="makanan" {{ $item->kategori == 'makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="minuman" {{ $item->kategori == 'minuman' ? 'selected' : '' }}>Minuman</option>
                <option value="aktivitas" {{ $item->kategori == 'aktivitas' ? 'selected' : '' }}>Aktivitas</option>
                <option value="barang lainnya" {{ $item->kategori == 'barang lainnya' ? 'selected' : '' }}>Barang Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini</label><br>
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" width="120" class="img-thumbnail mb-2">
                <br>
                <button type="button" class="btn btn-sm btn-lihat-gambar" data-bs-toggle="modal" data-bs-target="#modalImage">
                    🖼️ Lihat Gambar Besar
                </button>

                <!-- Modal Bootstrap -->
                <div class="modal fade" id="modalImage" tabindex="-1" aria-labelledby="modalImageLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalImageLabel">Gambar Barang: {{ $item->nama_barang }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded shadow">
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <small class="text-muted">Tidak ada gambar</small>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Ganti Gambar (opsional)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-semibold">Update</button>
        <a href="{{ route('lists.show', $item->shopping_list_id) }}" class="btn btn-secondary rounded-pill px-4 py-2 ms-2">Kembali</a>
    </form>
</div>
@endsection