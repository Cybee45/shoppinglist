@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontsite/style/show.css') }}">
@endpush

@section('content')
    <div class="container">
        <h2>Daftar Belanja: {{ $list->name }}</h2>

        {{-- Tombol Tambah Item Baru --}}
        <div class="mb-3 text-end">
            <a href="{{ route('items.createTambah', ['list_id' => $list->id]) }}" class="btn btn-primary mb-3">
            + Tambah Item Baru
        </a>
        </div>

        @if ($list->items->count())
            <table class="table table-striped align-middle text-center">
                <thead>
                    <tr>
                        <th>Ceklist</th>
                        <th>Gambar</th>
                        <th>Lihat</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list->items as $item)
                        <tr>
                            <td>
                                <form action="{{ route('items.toggleStatus', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="checkbox" onchange="this.form.submit()"
                                        {{ $item->status === 'selesai' ? 'checked' : '' }}>
                                </form>
                            </td>
                            <td>
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="img-thumbnail" style="max-width: 90px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->image)
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalImage{{ $item->id }}">
                                        🖼️ Lihat
                                    </button>

                                    <!-- Modal Gambar -->
                                    <div class="modal fade" id="modalImage{{ $item->id }}" tabindex="-1" aria-labelledby="modalImageLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalImageLabel{{ $item->id }}">Gambar: {{ $item->nama_barang }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded shadow">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp {{ number_format($item->harga) }}</td>
                            <td>{{ ucfirst($item->kategori) }}</td>
                            <td>
                                @if ($item->status === 'selesai')
                                    <span class="status-badge selesai">Selesai</span>
                                @else
                                    <span class="status-badge belum">Belum</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('items.edit', $item->id) }}" class="btn-edit btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete btn-sm btn-confirm" title="Hapus" data-message="Yakin hapus barang ini?">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="total-harga mt-3 p-3" style="background:#f0f0f0; border-radius:8px; max-width: 300px;">
                Total harga Rp {{ number_format($list->total_harga, 0, ',', '.') }}
            </div>
        @else
            <p>Belum ada barang di daftar ini.</p>
        @endif
    </div>

    <a href="{{ route('items.index') }}" class="btn btn-back mb-3">← Kembali ke Dashboard</a>
@endsection

@section('head')
    @if (session('success'))
        <script>
            window.STANDARD_SUCCESS_MESSAGE = @json(session('success'));
        </script>
    @endif
@endsection
