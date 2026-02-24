@extends('master')

@section('main')
    <div class="container-fluid py-4" style="background-color: #f8f9fa;">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">

                <div class="d-flex justify-content-between align-items-center mb-4 fade-in-up" style="animation-delay: 0.1s;">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Hasil Prediksi Panen</h4>
                        <p class="text-muted mb-0 small">Analisis cerdas berdasarkan data lahan Anda</p>
                    </div>
                    <div>
                        {{-- <button class="btn btn-light shadow-sm me-2 rounded-pill" onclick="window.print()">
                            <i class="bi bi-printer me-2"></i>Cetak
                        </button> --}}
                        <a class="btn btn-dark shadow-sm rounded-pill" href="{{ route('prediksi') }}">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4 overflow-hidden fade-in-up"
                    style="border-radius: 20px; animation-delay: 0.2s;">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-md-3 border-end-md p-4 bg-white hover-bg">
                                <small class="text-uppercase text-muted fw-bold d-block mb-1"
                                    style="font-size: 0.7rem; letter-spacing: 1px;">Lokasi</small>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-geo-alt text-danger me-2"></i>
                                    <div>
                                        <h6 class="mb-0 fw-bold">Desa {{ $input_data['Desa'] }}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem">{{ $input_data['Kecamatan'] }},
                                            {{ $input_data['Kabupaten'] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 border-end-md p-4 bg-white hover-bg">
                                <small class="text-uppercase text-muted fw-bold d-block mb-1"
                                    style="font-size: 0.7rem; letter-spacing: 1px;">Varietas</small>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-flower1 text-success me-2"></i>
                                    <h6 class="mb-0 fw-bold text-success">{{ $input_data['Varietas'] }}</h6>
                                </div>
                            </div>
                            <div class="col-md-3 border-end-md p-4 bg-white hover-bg">
                                <small class="text-uppercase text-muted fw-bold d-block mb-1"
                                    style="font-size: 0.7rem; letter-spacing: 1px;">Luas Tanam</small>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-aspect-ratio text-primary me-2"></i>
                                    <h6 class="mb-0 fw-bold">{{ $input_data['Luas_Lahan'] }} Hektar</h6>
                                </div>
                            </div>
                            <div class="col-md-3 p-4 bg-white hover-bg">
                                <small class="text-uppercase text-muted fw-bold d-block mb-1"
                                    style="font-size: 0.7rem; letter-spacing: 1px;">Mulai Tanam</small>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-calendar-event text-warning me-2"></i>
                                    <h6 class="mb-0 fw-bold">
                                        {{ \Carbon\Carbon::parse($input_data['Tanggal_Tanam'])->format('d M Y') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">

                    <div class="col-lg-12 fade-in-up" style="animation-delay: 0.3s;">
                        <div class="card border-0 shadow-lg text-white overflow-hidden card-hover-scale"
                            style="background: linear-gradient(120deg, #11998e 0%, #38ef7d 100%); border-radius: 24px;">
                            <div class="card-body p-4 p-md-5 position-relative">
                                <i class="bi bi-currency-dollar position-absolute text-white"
                                    style="font-size: 15rem; opacity: 0.1; right: -2rem; top: -3rem; transform: rotate(-15deg);"></i>

                                <div class="row align-items-center position-relative z-index-1">
                                    <div class="col-md-7">
                                        <span
                                            class="badge bg-white bg-opacity-25 backdrop-blur rounded-pill px-3 py-2 mb-3">
                                            <i class="bi bi-stars me-1"></i> Prediksi Pengeluaran
                                        </span>
                                        <h1 class="display-4 fw-bold mb-0">
                                            {{ number_format($hasil_prediksi['estimasi_pembayaran'], 0, ',', '.') }}</h1>
                                        <p class="mb-0 mt-2 text-white text-opacity-75">
                                            Dengan Harga Petani (Rp
                                            {{ number_format($input_data['Harga_Beli_Petani']) }}/Kg)
                                        </p>
                                    </div>
                                    <div class="col-md-5 text-md-end mt-4 mt-md-0">
                                        <div class="bg-white bg-opacity-10 backdrop-blur rounded-4 p-3 d-inline-block text-start"
                                            style="min-width: 200px;">
                                            <small class="d-block text-white text-opacity-75 mb-1">Prediksi Panen</small>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-box-seam fs-3 me-3"></i>
                                                <div>
                                                    <h3 class="fw-bold mb-0">{{ $hasil_prediksi['prediksi_panen_kg'] }} kg
                                                    </h3>
                                                    {{-- <small class="small">≈ 1,9 Ton/Ha</small> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 fade-in-up" style="animation-delay: 0.4s;">
                        <div class="card border-0 shadow-sm h-100 card-hover-scale"
                            style="border-radius: 24px; background: #fff;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="icon-box bg-indigo-light text-indigo rounded-circle">
                                        <i class="bi bi-calendar-check-fill fs-4"></i>
                                    </div>
                                    <span
                                        class="badge bg-light text-dark rounded-pill align-self-start">{{ $hasil_prediksi['umur_tanam'] }}</span>
                                </div>
                                <h6 class="text-muted text-uppercase small fw-bold ls-1">Estimasi Panen</h6>
                                <h2 class="fw-bold text-dark mb-1">
                                    {{ \Carbon\Carbon::parse($hasil_prediksi['estimasi_tanggal_panen'])->format('d M Y') }}
                                </h2>

                                {{-- <small class="text-muted mt-2 d-block">Sisa waktu menunggu panen</small> --}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 fade-in-up" style="animation-delay: 0.5s;">
                        <div class="card border-0 shadow-sm h-100 card-hover-scale"
                            style="border-radius: 24px; background: #fff;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="icon-box bg-orange-light text-orange rounded-circle">
                                        <i class="bi bi-thermometer-sun fs-4"></i>
                                    </div>
                                    <i class="bi bi-three-dots text-muted"></i>
                                </div>
                                <h6 class="text-muted text-uppercase small fw-bold ls-1">Suhu Rata-rata</h6>
                                <h2 class="fw-bold text-dark mb-1">{{ $hasil_prediksi['suhu'] }}C</h2>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 fade-in-up" style="animation-delay: 0.6s;">
                        <div class="card border-0 shadow-sm h-100 card-hover-scale"
                            style="border-radius: 24px; background: #fff;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="icon-box bg-blue-light text-blue rounded-circle">
                                        <i class="bi bi-cloud-drizzle-fill fs-4"></i>
                                    </div>
                                    <i class="bi bi-three-dots text-muted"></i>
                                </div>
                                <h6 class="text-muted text-uppercase small fw-bold ls-1">Rata-rata Curah Hujan</h6>
                                <h2 class="fw-bold text-dark mb-1">{{ $hasil_prediksi['curah_hujan'] }} <span
                                        class="fs-5 text-muted fw-normal">mm</span>
                                </h2>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row align-items-center fade-in-up" style="animation-delay: 0.7s;">
                    <div class="col-lg-8">
                        <div class="alert alert-light border shadow-sm rounded-4 d-flex align-items-center mb-lg-0">
                            <i class="bi bi-exclamation-circle-fill text-warning fs-4 me-3"></i>
                            <div>
                                <strong class="text-dark">Disclaimer Prediksi</strong>
                                <p class="mb-0 small text-muted lh-sm">
                                    Hasil ini adalah estimasi komputer berdasarkan data historis. Kondisi nyata di lapangan
                                    (hama, bencana alam) dapat mempengaruhi hasil akhir.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end">

                        <button class="btn btn-primary rounded-pill px-4 shadow-sm btn-pulse">
                            <i class="bi bi-arrow-clockwise me-2"></i>Prediksi Baru
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Custom Color Variables */
        :root {
            --indigo: #6610f2;
            --indigo-light: #e0cffc;
            --orange: #fd7e14;
            --orange-light: #ffe5d0;
            --blue: #0d6efd;
            --blue-light: #cfe2ff;
        }

        /* Utilities */
        .bg-indigo {
            background-color: var(--indigo) !important;
        }

        .bg-indigo-light {
            background-color: var(--indigo-light) !important;
        }

        .text-indigo {
            color: var(--indigo) !important;
        }

        .bg-orange-light {
            background-color: var(--orange-light) !important;
        }

        .text-orange {
            color: var(--orange) !important;
        }

        .bg-blue-light {
            background-color: var(--blue-light) !important;
        }

        .text-blue {
            color: var(--blue) !important;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .border-end-md {
            border-right: 1px solid #eee;
        }

        @media (max-width: 768px) {
            .border-end-md {
                border-right: none;
                border-bottom: 1px solid #eee;
            }
        }

        /* Icon Box */
        .icon-box {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Glass Effect */
        .backdrop-blur {
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        /* Hover Effects */
        .hover-bg {
            transition: background-color 0.3s ease;
        }

        .hover-bg:hover {
            background-color: #f8f9fa !important;
        }

        .card-hover-scale {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
        }

        .card-hover-scale:hover {
            transform: translateY(-8px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
        }

        /* Button Pulse Animation */
        @keyframes pulse-custom {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
            }
        }

        .btn-pulse {
            animation: pulse-custom 2s infinite;
        }

        /* Entrance Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 30px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .fade-in-up {
            opacity: 0;
            /* Initially hidden */
            animation-name: fadeInUp;
            animation-duration: 0.8s;
            animation-fill-mode: both;
        }

        /* Print Optimization */
        @media print {

            .btn,
            .no-print {
                display: none !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

            .text-white {
                color: black !important;
            }

            .bg-gradient {
                background: none !important;
                color: black !important;
            }

            body {
                background-color: white !important;
            }
        }
    </style>
@endsection
