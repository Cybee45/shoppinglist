@extends('layouts.app')

@section('title', 'Dashboard')

@section('head')
    {{-- Inject JS variable untuk alert sukses umum --}}
    @if (session('success'))
        <script>
            window.STANDARD_SUCCESS_MESSAGE = @json(session('success'));
        </script>
    @endif
@endsection

@section('content')

    <div class="section-header text-center mb-4">
        <h2 class="fw-bold text-dark">📋 Dashboard Daftar Belanja</h2>
        <p class="text-muted">Kelola semua kebutuhanmu dengan rapi dan terorganisir.</p>
    </div>

    {{-- Notifikasi standar --}}
    <div id="successCard" class="alert alert-success animate__animated animate__fadeInDown d-none"></div>

    {{-- Tombol buat list baru --}}
    <div class="custom-card mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-2 mb-md-0">
                <h5 class="fw-semibold text-dark mb-1">Ingin Membuat Daftar Belanja Baru?</h5>
                <small class="text-muted">Buat dan kelola barang belanjaanmu dengan mudah.</small>
            </div>
            <a href="{{ route('items.create') }}" class="btn btn-success px-4 py-2 rounded-pill">
                + Tambah List Baru
            </a>
        </div>
    </div>

    {{-- Daftar List Aktif --}}
    @if ($lists->count())
        <div class="row">
            @foreach ($lists as $list)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100 rounded-4">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title-primary">{{ $list->name }}</h5>
                                <p class="card-text"><small>{{ $list->items_count }} barang</small></p>
                                <p class="text-muted mb-1">🕒 {{ $list->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="mt-3 d-flex justify-content-between">
                                <a href="{{ route('lists.show', $list->id) }}" class="btn btn-sm btn-lihat">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>

                                <form action="{{ route('lists.complete', $list->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="button" class="btn btn-sm btn-selesai btn-confirm"
                                        data-message="Ingin memasukkan ke dalam History?">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </button>
                                </form>

                                <form action="{{ route('lists.destroy', $list->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-hapus btn-confirm"
                                        data-message="Yakin hapus daftar ini?">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <img src="{{ asset('images/List.png') }}" alt="Empty" width="180" class="mb-3">
            <h5 class="text-muted">Belum ada daftar belanja.</h5>
            <p class="text-muted">Yuk buat daftar pertamamu di atas! 🛒</p>
        </div>
    @endif

    {{-- Riwayat Belanja --}}
    <hr class="my-5">
    <h4 class="fw-bold text-primary mb-4">Riwayat Belanja (Selesai)</h4>
    <button class="toggle-history-btn" type="button" data-bs-toggle="collapse" data-bs-target="#historyListCollapse">
        Tampilkan / Sembunyikan Riwayat Belanja
    </button>

    <div class="collapse" id="historyListCollapse">
        @if ($listsSelesai->count())
            <div class="row">
                @foreach ($listsSelesai as $list)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100 rounded-4 card-history">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title text-success">{{ $list->name }}</h5>
                                    <p class="card-text"><small>{{ $list->items->count() }} barang</small></p>
                                    <p class="text-muted mb-1">{{ $list->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div class="mt-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalList{{ $list->id }}">Lihat</button>

                                    <form action="{{ route('lists.destroy', $list->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-confirm"
                                            data-message="Hapus daftar ini?">Hapus</button>
                                    </form>

                                    <form action="{{ route('lists.restore', $list->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="button" class="btn btn-sm btn-primary btn-confirm"
                                            data-message="Kembalikan list ini ke daftar aktif?">Restore?</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Detail --}}
                    <div class="modal fade" id="modalList{{ $list->id }}" tabindex="-1"
                        aria-labelledby="modalLabel{{ $list->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $list->name }}</h5>
                                    <p class="mb-0">
                                        <small class="text-muted">Total: 
                                            <strong>Rp {{ number_format($list->total_harga, 0, ',', '.') }}</strong>
                                        </small>
                                    </p>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Harga</th>
                                                <th>Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($list->items as $item)
                                                <tr>
                                                    <td>{{ $item->nama_barang }}</td>
                                                    <td>{{ $item->jumlah }}</td>
                                                    <td>Rp {{ number_format($item->harga) }}</td>
                                                    <td>{{ ucfirst($item->kategori) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted">Belum ada riwayat belanja yang selesai.</p>
        @endif
    </div>

@endsection