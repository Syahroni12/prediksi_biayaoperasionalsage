@extends('master')

@section('main')
    <div class="container-fluid">
        <div class="row g-3">

            {{-- ====== STAT CARD ====== --}}
            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-bar-chart fs-3"></i>
                        </div>
                        <div class="text-muted small">Total Prediksi</div>
                        <h3 class="fw-bold">125</h3>
                        <div class="text-muted small">Prediksi bulan ini</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-bullseye fs-3"></i>
                        </div>
                        <div class="text-muted small">Prediksi Terakhir</div>
                        <h3 class="fw-bold">32.5</h3>
                        <div class="text-muted small">Ton hasil panen</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-graph-down fs-3"></i>
                        </div>
                        <div class="text-muted small">Stok Rendah</div>
                        <h3 class="fw-bold">8</h3>
                        <div class="text-muted small">Varietas benih</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="bi bi-calendar-event fs-3"></i>
                        </div>
                        <div class="text-muted small">Jadwal Panen</div>
                        <h3 class="fw-bold">15</h3>
                        <div class="text-muted small">Hari lagi</div>
                    </div>
                </div>
            </div>

            {{-- ====== CARD DETAIL PREDIKSI ====== --}}
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Prediksi I (Estimasi Hasil Panen)</h6>
                        <ul class="list-unstyled small">
                            <li><strong>Luas Lahan:</strong> 25 Ha</li>
                            <li><strong>Varietas:</strong> SAGE B</li>
                            <li><strong>Lokasi:</strong> Singosari, Malang</li>
                            <li><strong>Tanggal Tanam:</strong> 15 Juli 2025</li>
                            <li><strong>Prediksi Hasil:</strong> 32.5 Ton</li>
                            <li><strong>Confidence Level:</strong> 87%</li>
                        </ul>
                        <a href="#" class="btn btn-success w-100 mt-3">Mulai Prediksi Panen</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Prediksi II (Estimasi Stok Benih)</h6>
                        <ul class="list-unstyled small">
                            <li><strong>Benih Tersedia:</strong> 1250 Kg</li>
                            <li><strong>Kebutuhan Bulanan:</strong> 180 Kg</li>
                            <li><strong>Stok Akan Habis:</strong> 6.9 Bulan</li>
                            <li><strong>Reorder Point:</strong> 300 Kg</li>
                            <li><strong>Status Stok:</strong> Aman</li>
                            <li><strong>Supplier:</strong> PT Sago</li>
                        </ul>
                        <a href="#" class="btn btn-success w-100 mt-3">Hitung Stok Benih</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Riwayat Prediksi</h6>
                        <ul class="list-unstyled small">
                            <li><strong>Luas Lahan:</strong> 25 Ha</li>
                            <li><strong>Varietas:</strong> SAGE B</li>
                            <li><strong>Lokasi:</strong> Singosari, Malang</li>
                            <li><strong>Tanggal Tanam:</strong> 15 Juli 2025</li>
                            <li><strong>Prediksi Hasil:</strong> 32.5 Ton</li>
                            <li><strong>Confidence Level:</strong> 87%</li>
                        </ul>
                        <a href="#" class="btn btn-outline-secondary w-100 mt-3">Lihat Riwayat</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
