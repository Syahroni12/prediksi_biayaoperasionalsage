@extends('master')

@section('main')
    <style>
        .table-hover tbody tr:hover {
            background-color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            z-index: 1;
        }

        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        /* Pagination Styling */
        .page-link {
            border-radius: 50% !important;
            margin: 0 3px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            color: #6c757d;
            font-weight: 500;
        }

        .page-item.active .page-link {
            background-color: #11998e;
            color: white;
            box-shadow: 0 3px 10px rgba(17, 153, 142, 0.3);
        }

        /* Animation */
        .fade-in-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">

                {{-- ====== HEADER SECTION ====== --}}
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 fade-in-up"
                    style="animation-delay: 0.1s;">

                    {{-- Judul Halaman --}}
                    <div class="mb-3 mb-md-0">
                        <h4 class="fw-bold text-dark mb-1">Riwayat Prediksi</h4>
                        <p class="text-muted mb-0 small">Daftar semua analisis lahan yang telah tersimpan</p>
                    </div>

                    {{-- Group Aksi (Export & Search) --}}
                    <div class="d-flex gap-2 align-items-center w-100 w-md-auto" style="max-width: 600px;">

                        {{-- TOMBOL EXPORT (Memicu Modal) --}}
                        <button type="button"
                            class="btn btn-success rounded-pill shadow-sm px-3 d-flex align-items-center gap-2"
                            data-bs-toggle="modal" data-bs-target="#exportModal" style="white-space: nowrap; height: 45px;">
                            <i class="bi bi-file-earmark-spreadsheet"></i>
                            <span class="d-none d-sm-inline">Export</span>
                        </button>

                        {{-- Search Form --}}
                        <form class="position-relative flex-grow-1" action="" method="GET">
                            <i
                                class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted z-1"></i>

                            <input type="text" class="form-control rounded-pill ps-5 border-0 shadow-sm"
                                style="height: 45px; padding-right: 90px;" placeholder="Cari Desa/Varietas..."
                                name="search" value="{{ request('search') }}">

                            <button type="submit"
                                class="btn btn-primary rounded-pill position-absolute top-0 end-0 m-1 px-4 shadow-sm d-flex align-items-center"
                                style="height: calc(100% - 8px);">
                                Cari
                            </button>
                        </form>
                    </div>
                </div>

                {{-- ====== CARD TABLE ====== --}}
                <div class="card border-0 shadow-sm overflow-hidden fade-in-up"
                    style="border-radius: 20px; animation-delay: 0.2s;">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="text-center">
                                        <th class="ps-4 py-3 text-uppercase text-muted small fw-bold">Tanggal Tanam</th>
                                        <th class="py-3 text-uppercase text-muted small fw-bold">Lokasi Lahan</th>
                                        <th class="py-3 text-uppercase text-muted small fw-bold">Luas Lahan</th>
                                        <th class="py-3 text-uppercase text-muted small fw-bold">Estimasi Hasil</th>
                                        <th class="py-3 text-uppercase text-muted small fw-bold">Estimasi Biaya (Rp)</th>
                                        <th class="pe-4 py-3 text-end text-uppercase text-muted small fw-bold text-center">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($histori as $item)
                                        <tr class="text-center">
                                            {{-- Tanggal Tanam --}}
                                            <td class="ps-4">
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->tanggal_tanam)->format('d M Y') }}</span>
                                                </div>
                                            </td>

                                            {{-- Lokasi --}}
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="text-start">
                                                        <h6 class="mb-0 fw-bold text-dark">{{ $item->desa }}</h6>
                                                        <div class="text-muted small">{{ $item->kecamatan }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Luas --}}
                                            <td>
                                                <span class="badge bg-light text-dark border rounded-pill px-3">
                                                    {{ $item->luas_lahan }} Ha
                                                </span>
                                            </td>

                                            {{-- Estimasi Panen --}}
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-dark">{{ $item->estimasi_panen }}
                                                        Kg</span>
                                                    <small class="text-muted text-nowrap">
                                                        <i class="bi bi-calendar-check me-1"></i>
                                                        Panen:
                                                        {{ \Carbon\Carbon::parse($item->tanggal_panen)->format('d M Y') }}
                                                    </small>
                                                </div>
                                            </td>

                                            {{-- Biaya --}}
                                            <td>
                                                <span class="fw-bold text-success">
                                                    Rp {{ $item->estimasi_biaya }}
                                                </span>
                                            </td>

                                            {{-- Aksi --}}
                                            <td class="pe-4 text-end">
                                                <div class="btn-group">
                                                    <a href="{{ route('detail_history', $item->id) }}"
                                                        class="btn btn-sm btn-light text-primary shadow-sm rounded-pill me-2"
                                                        title="Lihat Detail">
                                                        <i class="bi bi-eye"></i> <span
                                                            class="d-none d-lg-inline">Detail</span>
                                                    </a>
                                                    {{-- Contoh Form Delete (Opsional) --}}
                                                    {{-- <form action="" method="POST" onsubmit="return confirm('Hapus data?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light text-danger shadow-sm rounded-pill">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form> --}}
                                                    <a href="#"
                                                        class="btn btn-sm btn-danger text-light shadow-sm rounded-pill"
                                                        title="Hapus" onclick="hapus({{ $item->id }})">
                                                        hapus
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <div class="py-4">
                                                    <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                                        <i class="bi bi-clipboard-data text-muted fs-1"></i>
                                                    </div>
                                                    <h5 class="text-muted mb-1">Belum ada riwayat prediksi</h5>
                                                    <p class="text-muted small mb-3">Mulai lakukan analisis lahan pertama
                                                        Anda.</p>
                                                    <a href="{{ route('prediksi') }}"
                                                        class="btn btn-outline-primary rounded-pill btn-sm px-4">
                                                        Buat Prediksi
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    {{-- ====== MODAL EXPORT ====== --}}
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header bg-success text-white"
                    style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title fw-bold" id="exportModalLabel">
                        <i class="bi bi-file-earmark-excel me-2"></i>Export Laporan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                {{-- Pastikan route 'history.export' sudah dibuat di web.php --}}
                <form action="{{ route('export_history') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="text-muted small mb-4">Pilih rentang <strong>Tanggal Tanam</strong> untuk data yang ingin
                            di-export.</p>

                        <div class="row g-3">
                            <div class="col-6">
                                <label for="start_date" class="form-label fw-bold small text-uppercase text-muted">Dari
                                    Tanggal</label>
                                <input type="date" class="form-control bg-light border-0" id="start_date"
                                    name="start_date" required>
                            </div>
                            <div class="col-6">
                                <label for="end_date" class="form-label fw-bold small text-uppercase text-muted">Sampai
                                    Tanggal</label>
                                <input type="date" class="form-control bg-light border-0" id="end_date"
                                    name="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light text-muted rounded-pill px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                            <i class="bi bi-download me-1"></i> Download Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function hapus(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus data?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "/hapus_prediksi/" + id;
                }
            });
        }
    </script>

    {{-- Custom Style --}}
@endsection
