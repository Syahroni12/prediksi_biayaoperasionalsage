@extends('master')

@section('main')
    <div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-9">

                {{-- Header & Navigasi --}}
                <div class="d-flex justify-content-between align-items-center mb-4 fade-in-up">
                    <div>
                        <a href="{{ route('history') }}" class="text-decoration-none text-muted small mb-1 d-inline-block">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
                        </a>
                        <h4 class="fw-bold text-dark mb-0">Detail Prediksi #{{ $detail->id }}</h4>
                    </div>

                </div>

                <div class="card border-0 shadow-sm overflow-hidden fade-in-up"
                    style="border-radius: 20px; animation-delay: 0.1s;">

                    {{-- Bagian 1: Header Status (Tanggal Dibuat) --}}
                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-light text-primary rounded-circle me-3 p-3">
                                <i class="bi bi-calendar-check fs-4"></i>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted fw-bold"
                                    style="font-size: 0.7rem; letter-spacing: 1px;">Waktu Analisis</small>
                                <h6 class="mb-0 fw-bold text-dark">
                                    {{ \Carbon\Carbon::parse($detail->created_at)->translatedFormat('l, d F Y') }}
                                    <span class="text-muted fw-normal">Pukul
                                        {{ \Carbon\Carbon::parse($detail->created_at)->format('H:i') }}</span>
                                </h6>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">

                        {{-- GROUP 1: Lokasi Lahan --}}
                        <div class="p-4">
                            <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                <i class="bi bi-geo-alt-fill me-2"></i>Lokasi Lahan
                            </h6>

                            {{-- Row Item --}}
                            <div class="row py-2">
                                <div class="col-sm-4 text-muted">Desa</div>
                                <div class="col-sm-8 fw-bold text-dark">{{ $detail->desa }}</div>
                            </div>
                            <div class="row py-2 bg-light rounded">
                                <div class="col-sm-4 text-muted">Kecamatan</div>
                                <div class="col-sm-8 fw-bold text-dark">{{ $detail->kecamatan }}</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-sm-4 text-muted">Kabupaten</div>
                                <div class="col-sm-8 fw-bold text-dark">{{ $detail->kabupaten }}</div>
                            </div>
                        </div>

                        {{-- GROUP 2: Data Teknis & Lingkungan --}}
                        <div class="p-4 bg-light bg-opacity-50">
                            <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">
                                <i class="bi bi-clipboard-data-fill me-2"></i>Parameter Input
                            </h6>

                            {{-- Row Item --}}
                            <div class="row py-2">
                                <div class="col-sm-4 text-muted">Varietas Padi</div>
                                <div class="col-sm-8 fw-bold text-dark">
                                    {{-- Menampilkan nama varietas jika relasi ada, atau ID jika tidak --}}
                                    {{ $detail->varietas ? $detail->varietas->varietas : 'ID: ' . $detail->varietas_id }}
                                </div>
                            </div>
                            <div class="row py-2 bg-white rounded shadow-sm">
                                <div class="col-sm-4 text-muted">Luas Lahan</div>
                                <div class="col-sm-8 fw-bold text-dark">{{ $detail->luas_lahan }} Hektar</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-sm-4 text-muted">Tanggal Tanam</div>
                                <div class="col-sm-8 fw-bold text-dark">
                                    {{ \Carbon\Carbon::parse($detail->tanggal_tanam)->translatedFormat('d F Y') }}</div>
                            </div>
                            <div class="row py-2 bg-white rounded shadow-sm">
                                <div class="col-sm-4 text-muted">Umur Tanaman</div>
                                <div class="col-sm-8 fw-bold text-dark">{{ $detail->umur_tanaman }} Hari</div>
                            </div>
                            <div class="row py-2">
                                <div class="col-sm-4 text-muted">Rata-rata Suhu</div>
                                <div class="col-sm-8 fw-bold text-dark">{{ $detail->mean_suhu }} &deg;C</div>
                            </div>
                            <div class="row py-2 bg-white rounded shadow-sm">
                                <div class="col-sm-4 text-muted">Rata-rata Curah Hujan</div>
                                <div class="col-sm-8 fw-bold text-dark">{{ $detail->mean_hujan }} mm</div>
                            </div>
                        </div>

                        {{-- GROUP 3: Hasil Prediksi (Highlight) --}}
                        <div class="p-4" style="background: #f1fcfc;">
                            <h6 class="text-success fw-bold mb-3 border-bottom border-success pb-2 border-opacity-25">
                                <i class="bi bi-stars me-2"></i>Hasil Analisis (Output)
                            </h6>

                            <div class="row py-2">
                                <div class="col-sm-4 text-muted">Estimasi Tanggal Panen</div>
                                <div class="col-sm-8 fw-bold text-success fs-5">
                                    {{ \Carbon\Carbon::parse($detail->tanggal_panen)->translatedFormat('d F Y') }}
                                </div>
                            </div>

                            <div class="row py-2 bg-white rounded shadow-sm border-start border-4 border-success">
                                <div class="col-sm-4 text-muted align-self-center">Estimasi Hasil Panen</div>
                                <div class="col-sm-8 fw-bold text-dark fs-5">
                                    {{ number_format($detail->estimasi_panen, 0, ',', '.') }} Kg
                                </div>
                            </div>

                            <div class="row py-2 mt-2">
                                <div class="col-sm-4 text-muted">Harga Beli Petani</div>
                                <div class="col-sm-8 fw-bold text-dark">
                                    Rp {{ number_format($detail->harga_beli, 0, ',', '.') }} / Kg
                                </div>
                            </div>

                            <div class="row py-2 mt-2 bg-success text-white rounded shadow"
                                style="background: linear-gradient(120deg, #11998e 0%, #38ef7d 100%);">
                                <div class="col-sm-4 align-self-center">Estimasi Pengeluaran</div>
                                <div class="col-sm-8 fw-bold fs-4">
                                    Rp {{ number_format($detail->estimasi_biaya, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        {{-- Footer Info --}}


                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Styling tambahan untuk baris */
        .row {
            align-items: center;
            /* Vertikal center */
        }

        .text-muted {
            font-weight: 500;
            /* Label agak tebal tapi abu-abu */
        }

        /* Efek Print agar rapi saat dicetak */
        @media print {

            .btn,
            a {
                display: none !important;
            }

            /* Sembunyikan tombol */
            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }

            body {
                background-color: white !important;
            }
        }
    </style>
@endsection
