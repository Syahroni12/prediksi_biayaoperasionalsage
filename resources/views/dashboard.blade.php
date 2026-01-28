@extends('master')

@section('main')
    <style>
        /* Custom Animations & Styles */
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 12px;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .icon-box {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df, #224abe);
            color: white;
        }

        .bg-gradient-success {
            background: linear-gradient(45deg, #1cc88a, #13855c);
            color: white;
        }

        .bg-gradient-info {
            background: linear-gradient(45deg, #36b9cc, #258391);
            color: white;
        }

        .bg-gradient-warning {
            background: linear-gradient(45deg, #f6c23e, #dda20a);
            color: white;
        }
    </style>

    <div class="container-fluid py-4 fade-in-up">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark">Dashboard Overview</h4>
            <a href="{{ route('prediksi') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Buat Prediksi Baru
            </a>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card hover-card shadow-sm h-100 py-2 border-start border-4 border-primary">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Prediksi</div>
                                <div class="h3 mb-0 fw-bold text-gray-800">{{ $totalPrediksi }}</div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-box bg-gradient-primary">
                                    <i class="bi bi-bar-chart fs-4 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card hover-card shadow-sm h-100 py-2 border-start border-4 border-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-info text-uppercase mb-1">Bulan Ini</div>
                                <div class="h3 mb-0 fw-bold text-gray-800">{{ $prediksiBulanIni }}</div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-box bg-gradient-info">
                                    <i class="bi bi-calendar-check fs-4 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card hover-card shadow-sm h-100 py-2 border-start border-4 border-success">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-success text-uppercase mb-1">Est. Panen Terakhir</div>
                                <div class="h3 mb-0 fw-bold text-gray-800">
                                    {{ $prediksiTerakhir?->estimasi_panen ?? 0 }} <span class="fs-6 text-muted">Kg</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-box bg-gradient-success">
                                    <i class="bi bi-bullseye fs-4 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card hover-card shadow-sm h-100 py-2 border-start border-4 border-warning">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-warning text-uppercase mb-1">Est. Biaya</div>
                                <div class="h3 mb-0 fw-bold text-gray-800">
                                    <span class="fs-6">Rp</span>
                                    {{ number_format($prediksiTerakhir?->estimasi_biaya ?? 0) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="icon-box bg-gradient-warning">
                                    <i class="bi bi-cash-stack fs-4 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-lg-8">
                <div class="card shadow-sm hover-card h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold text-primary">🌱 Detail Prediksi Terakhir</h6>
                        @if ($prediksiTerakhir)
                            <span class="badge bg-light text-dark border">{{ $prediksiTerakhir->tanggal_tanam }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($prediksiTerakhir)
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                            <span class="text-muted"><i class="bi bi-flower1 me-2"></i>Varietas</span>
                                            <span class="fw-bold">{{ $prediksiTerakhir->varietas->varietas }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                            <span class="text-muted"><i class="bi bi-aspect-ratio me-2"></i>Luas
                                                Lahan</span>
                                            <span class="fw-bold">{{ $prediksiTerakhir->luas_lahan }} Ha</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                            <span class="text-muted"><i class="bi bi-hourglass-split me-2"></i>Umur
                                                Tanaman</span>
                                            <span class="fw-bold">{{ $prediksiTerakhir->umur_tanaman }} Hari</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                            <span class="text-muted"><i class="bi bi-hourglass-split me-2"></i>Harga Beli
                                                Petani
                                            </span>
                                            <span class="fw-bold">{{ $prediksiTerakhir->harga_beli }} </span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                            <span class="text-muted"><i class="bi bi-geo-alt me-2"></i>Lokasi</span>
                                            <span class="text-end small fw-bold">{{ $prediksiTerakhir->desa }},
                                                {{ $prediksiTerakhir->kecamatan }}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                            <span class="text-muted"><i class="bi bi-cloud-drizzle me-2"></i>Curah
                                                Hujan</span>
                                            <span class="fw-bold">{{ $prediksiTerakhir->mean_hujan }} mm</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center ps-0">
                                            <span class="text-muted"><i class="bi bi-thermometer-sun me-2"></i>Suhu
                                                Rata-rata</span>
                                            <span class="fw-bold">{{ $prediksiTerakhir->mean_suhu }}°C</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="alert alert-info d-flex align-items-center mt-4" role="alert">
                                <i class="bi bi-info-circle-fill flex-shrink-0 me-2"></i>
                                <div class="small">
                                    Berdasarkan data historis, estimasi panen sebesar
                                    <strong>{{ $prediksiTerakhir->estimasi_panen }} Kg</strong>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" width="80"
                                    class="mb-3 opacity-50" alt="No Data">
                                <p class="text-muted">Belum ada data prediksi yang dibuat.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm hover-card h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 fw-bold text-primary">🕒 Riwayat Terbaru</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($riwayat as $item)
                                <div class="list-group-item px-4 py-3 border-bottom-0">
                                    <div class="d-flex w-100 justify-content-between mb-1">
                                        <h6 class="mb-0 fw-bold text-dark">{{ $item->varietas->varietas }}</h6>

                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="badge bg-light text-secondary border">{{ $item->luas_lahan }}
                                            Ha</span>
                                        <span class="fw-bold text-success small">{{ $item->estimasi_panen }} Kg</span>
                                    </div>
                                </div>
                                <hr class="my-0 mx-3 text-muted opacity-25">
                            @empty
                                <div class="p-4 text-center text-muted small">Belum ada riwayat</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer bg-white text-center py-3 border-0">
                        <a href="{{ route('history') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                            Lihat Semua Riwayat
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
