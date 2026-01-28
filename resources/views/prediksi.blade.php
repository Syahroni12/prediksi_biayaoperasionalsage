@extends('master')

@section('main')
    <style>
        .loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(255, 255, 255, 0.85);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-sm animate__animated animate__fadeIn">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">Prediksi Estimasi Hasil Panen</h5>

                        {{-- ================= FORM INPUT (FULL WIDTH) ================= --}}
                        <div class="border rounded p-4 mb-4">
                            <div class="bg-light p-2 rounded mb-3 small fw-semibold">
                                Input Data Pra - Panen
                            </div>

                            <form action="{{ route('prediksiact') }}" method="POST">
                                @csrf

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Luas Lahan</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="Luas_Lahan"
                                                placeholder="0.2 atau 1" value="{{ old('Luas_Lahan') }}"
                                                oninput="formatLuasLahan(this)">
                                            <span class="input-group-text">Ha</span>
                                        </div>

                                        <!-- Tulisan merah -->
                                        <small class="text-danger">
                                            Gunakan tanda titik (.) bukan koma (,)
                                        </small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Jenis / Varietas Jagung</label>
                                        <select class="form-select" name="Varietas">
                                            <option value="">-- Pilih Varietas --</option>
                                            <option value="SAGE 1B" @if (old('Varietas') == 'SAGE 1B') selected @endif>SAGE
                                                1B</option>
                                            <option value="SAGE 5" @if (old('Varietas') == 'SAGE 5') selected @endif>SAGE 5
                                            </option>
                                            <option value="SAGE 7" @if (old('Varietas') == 'SAGE 7') selected @endif>SAGE 7
                                            </option>
                                            <option value="SAGE 2" @if (old('Varietas') == 'SAGE 2') selected @endif>SAGE 2
                                            </option>



                                        </select>
                                    </div>
                                    <input type="hidden" name="kabupaten_nama" id="kabupaten_nama">
                                    <input type="hidden" name="kecamatan_nama" id="kecamatan_nama">
                                    <div class="col-md-6">
                                        <label class="form-label">Harga Beli Petani</label>
                                        <input type="number" class="form-control" name="Harga_Beli_Petani" placeholder="0"
                                            value="{{ old('Harga_Beli_Petani') }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Tanam</label>
                                        <input type="date" class="form-control" name="Tanggal_Tanam"
                                            value="{{ old('Tanggal_Tanam') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Kabupaten</label>
                                        <select class="form-control" id="kabupaten" name="Kabupaten">
                                            <option value="">-- Pilih Kabupaten --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Kecamatan</label>
                                        <select class="form-control" id="kecamatan" name="Kecamatan" disabled>
                                            <option value="">-- Pilih Kecamatan --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Desa</label>
                                        <select class="form-control" id="desa" name="Desa" disabled>
                                            <option value="">-- Pilih Desa --</option>
                                        </select>
                                    </div>


                                    <div class="col-12 mt-3">
                                        <button type="submit" id="btnPrediksi" class="btn btn-success w-100">
                                            Mulai Prediksi
                                        </button>

                                    </div>

                                </div>
                            </form>
                            <div id="loadingOverlay" class="loading-overlay d-none">
                                <div class="text-center">
                                    <div class="spinner-border text-success mb-3" role="status"></div>
                                    <div class="fw-semibold">Sedang menghitung prediksi panen...</div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function formatLuasLahan(input) {
            // ganti koma jadi titik
            input.value = input.value.replace(/,/g, '.');

            // hanya boleh angka dan satu titik
            input.value = input.value
                .replace(/[^0-9.]/g, '') // hapus selain angka & titik
                .replace(/(\..*)\./g, '$1'); // cegah titik lebih dari satu
        }
        console.log('SCRIPT JALAN');

        // kabupaten yang diizinkan
        const kabupatenAllowed = [
            "banyuwangi",
            "jember",
            "bondowoso",
            "lumajang",
            "badung",
            "buleleng"
        ];

        // kode provinsi
        const PROV_JATIM = 35;
        const PROV_BALI = 51;

        // element form
        const kabSelect = document.getElementById('kabupaten');
        const kecSelect = document.getElementById('kecamatan');
        const desaSelect = document.getElementById('desa');

        // util
        function capitalize(text) {
            return text.replace(/\b\w/g, c => c.toUpperCase());
        }

        // ===============================
        // LOAD KABUPATEN
        // ===============================
        async function loadKabupaten() {
            try {
                const jatim = await fetch(
                    `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${PROV_JATIM}.json`
                ).then(r => r.json());

                const bali = await fetch(
                    `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${PROV_BALI}.json`
                ).then(r => r.json());

                const allKab = [...jatim, ...bali];

                allKab.forEach(kab => {
                    const namaKabRaw = kab.name
                        .replace(/^(kabupaten|kota)\s+/i, '')
                        .trim()
                        .toLowerCase();

                    if (kabupatenAllowed.includes(namaKabRaw)) {
                        kabSelect.insertAdjacentHTML(
                            'beforeend',
                            `<option value="${kab.id}" data-name="${capitalize(namaKabRaw)}">
                        ${capitalize(namaKabRaw)}
                    </option>`
                        );
                    }
                });

            } catch (e) {
                console.error('GAGAL LOAD KABUPATEN', e);
            }
        }

        // ===============================
        // KABUPATEN → KECAMATAN
        // ===============================
        kabSelect.addEventListener('change', async function() {
            const kabId = this.value;

            kecSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
            kecSelect.disabled = true;
            desaSelect.disabled = true;

            if (!kabId) return;

            try {
                const kecamatan = await fetch(
                    `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabId}.json`
                ).then(r => r.json());

                kecamatan.forEach(kec => {
                    kecSelect.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${kec.id}" data-name="${kec.name}">
                    ${kec.name}
                </option>`
                    );
                });

                kecSelect.disabled = false;
            } catch (e) {
                console.error('GAGAL LOAD KECAMATAN', e);
            }
        });

        // ===============================
        // KECAMATAN → DESA
        // ===============================
        kecSelect.addEventListener('change', async function() {
            const kecId = this.value;

            desaSelect.innerHTML = '<option value="">-- Pilih Desa --</option>';
            desaSelect.disabled = true;

            if (!kecId) return;

            try {
                const desa = await fetch(
                    `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecId}.json`
                ).then(r => r.json());

                desa.forEach(d => {
                    desaSelect.insertAdjacentHTML(
                        'beforeend',
                        `<option value="${d.name}" data-name="${d.name}">
                    ${d.name}
                </option>`
                    );
                });

                desaSelect.disabled = false;
            } catch (e) {
                console.error('GAGAL LOAD DESA', e);
            }
        });

        // ===============================
        // START
        // ===============================
        loadKabupaten();
        const form = document.querySelector('form');
        const btn = document.getElementById('btnPrediksi');
        const overlay = document.getElementById('loadingOverlay');
        document.querySelector('form').addEventListener('submit', function() {
            const selectedKab = kabSelect.selectedOptions[0];
            const selectedKec = kecSelect.selectedOptions[0];
            // const selectedDesa = desaSelect.selectedOptions[0];

            document.getElementById('kabupaten_nama').value = selectedKab?.dataset.name || '';
            document.getElementById('kecamatan_nama').value = selectedKec?.dataset.name || '';
            // document.getElementById('desa_nama').value = selectedDesa?.dataset.name || '';

            btn.disabled = true;

            // ubah teks
            btn.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2"></span>
            Memproses Prediksi...
        `;

            // tampilkan overlay
            overlay.classList.remove('d-none');
        });
    </script>
@endsection
