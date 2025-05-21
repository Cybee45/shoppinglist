@extends('layouts.app')

@section('title', 'Buat Daftar Belanja Baru')

@section('head')
    <link href="{{ asset('Frontsite/style/create.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container form-container">
    <h2 class="title">
        <i class="fa-solid fa-list icon"></i> Buat Daftar Belanja Baru
    </h2>

    <form id="listForm" method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data" class="form-modern">
        @csrf

        <div class="mb-3">
            <label class="form-label" for="name">
                <i class="fa-solid fa-list"></i> Nama List
            </label>
            <input type="text" id="name" name="name" class="form-control" required placeholder="Masukkan nama list belanja">
        </div>

        <hr>

        <h4>Tambah Barang</h4>
        <div id="barangInput" class="mb-3">
            <label class="form-label" for="nama_barang">
                <i class="fa-solid fa-box"></i> Nama Barang
            </label>
            <input type="text" id="nama_barang" placeholder="Nama Barang" class="form-control mb-2" autocomplete="off">

            <label class="form-label" for="jumlah">
                <i class="fa-solid fa-list-ol"></i> Jumlah
            </label>
            <input type="number" id="jumlah" placeholder="Jumlah" class="form-control mb-2" min="1" autocomplete="off">

            <label class="form-label" for="harga">
                <i class="fa-solid fa-dollar-sign"></i> Harga
            </label>
            <input type="number" id="harga" placeholder="Harga" class="form-control mb-2" min="0" autocomplete="off">

            <label class="form-label" for="kategori">
                <i class="fa-solid fa-tags"></i> Kategori
            </label>
            <select id="kategori" class="form-select mb-2">
                <option value="makanan">🥦 Makanan</option>
                <option value="minuman">🍹 Minuman</option>
                <option value="aktivitas">🏃 Aktivitas</option>
                <option value="barang lainnya">📦 Barang Lainnya</option>
            </select>

            <label class="form-label" for="image">
                <i class="fa-solid fa-image"></i> Gambar Barang
            </label>
            <input type="file" name="image" id="image" class="form-control mb-3" accept="image/*">

            <button type="button" id="addBarangBtn" class="btn btn-success btn-icon">
                <i class="fa-solid fa-plus"></i> Tambah Barang
            </button>
        </div>

        <h4>Daftar Barang Aktif</h4>
        <div class="table-responsive mb-3">
            <table class="table table-hover" id="barangListTable">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Barang aktif akan tampil di sini -->
                </tbody>
            </table>
        </div>

            <button id="simpanListBtn" type="button" class="btn btn-primary btn-icon mb-3">
                <i class="fa-solid fa-floppy-disk"></i> Simpan List
            </button>
        </form>

    <a href="{{ route('items.index') }}" class="btn-kembali">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<script src="{{ asset('Frontsite/js/create.js') }}"></script>
<script src="{{ asset('Frontsite/js/sweetalert.js') }}"></script>
@stack('scripts')

@endsection