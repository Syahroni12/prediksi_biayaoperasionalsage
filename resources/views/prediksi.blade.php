@extends('master')

@section('main')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">Prediksi Estimasi Hasil Panen</h5>

                        <div class="row g-4">

                            {{-- ================= LEFT FORM ================= --}}
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="bg-light p-2 rounded mb-3 small fw-semibold">
                                        Input Data Pra - Panen
                                    </div>

                                    <form action="#" method="POST">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label">Luas Lahan</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="luas_lahan">
                                                <span class="input-group-text">Ha</span>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jenis / Varietas Jagung</label>
                                            <select class="form-select" name="varietas">
                                                <option value="">-- Pilih Varietas --</option>
                                                <option value="SAGE B">SAGE B</option>
                                                <option value="BISI 18">BISI 18</option>
                                                <option value="NK 212">NK 212</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Harga Beli Petani</label>
                                            <input type="number" class="form-control" name="harga_beli">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Tanam</label>
                                            <input type="date" class="form-control" name="tanggal_tanam">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kabupaten</label>
                                            <input type="text" class="form-control" name="kabupaten">
                                        </div>

                                        <button type="submit" class="btn btn-success w-100">
                                            Mulai Prediksi
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- ================= RIGHT RESULT ================= --}}
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100 bg-light">
                                    <div class="bg-white p-2 rounded mb-3 small fw-semibold text-center">
                                        Hasil Panen
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Hasil Panen</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="-" readonly>
                                            <span class="input-group-text">kg</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Total Biaya Pengeluaran</label>
                                        <input type="text" class="form-control" value="-" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tingkat Akurasi</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="-" readonly>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <div class="text-muted small mt-4">
                                        Hasil akan muncul setelah proses prediksi dilakukan.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
