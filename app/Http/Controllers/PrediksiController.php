<?php

namespace App\Http\Controllers;

use App\Exports\HistoriExport;
use App\Models\Prediksi;
use App\Models\Varietas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
// use Maatwebsite\Excel\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;

class PrediksiController extends Controller
{
    public function prediksi(Request $request)
    {
        /* ===============================
       1. VALIDASI
    ================================ */
        $validator = Validator::make($request->all(), [
            'kabupaten_nama'          => 'required|string',
            'kecamatan_nama'          => 'required|string',
            'Desa'               => 'required|string',
            'Tanggal_Tanam'      => 'required',
            'Luas_Lahan'         => 'required|numeric|min:0.01',
            'Harga_Beli_Petani'  => 'required|numeric|min:0',
            'Varietas'           => 'required|string'
        ]);

        // Alert::error('Gagal', $validator->messages()->first());
        // dump($validator->messages());
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->messages()->first());
            return redirect()->back()->withInput();
        }
        // return redirect()->back()->withInput();
        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Validasi gagal',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        /* ===============================
       2. NORMALISASI DATA
    ================================ */

        $payload = [
            "Kabupaten" => strtoupper($request->kabupaten_nama),
            "Kecamatan" => strtoupper($request->kecamatan_nama),
            "Desa" => strtoupper($request->Desa),
            "Tanggal_Tanam" => Carbon::parse($request->Tanggal_Tanam)->format('Y-m-d'),
            "Luas_Lahan" => (float) str_replace(',', '.', $request->Luas_Lahan),
            "Harga_Beli_Petani" => (int) $request->Harga_Beli_Petani,
            "Varietas" => strtoupper($request->Varietas)
        ];

        /* ===============================
       3. KIRIM KE FASTAPI
    ================================ */
        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->post('http://127.0.0.1:8001/prediksi', $payload);

            if (!$response->successful()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'API prediksi gagal',
                    'detail' => $response->json()
                ], $response->status());
            }
            session([
                'prediksi_result' => $response->json(),
                'prediksi_input'  => $payload
            ]);
            // dump($_SESSION['prediksi_result']);


            $varietas_id = Varietas::where('varietas', $request->Varietas)->first()->id;
            Prediksi::create([
                'kabupaten'         => $request->kabupaten_nama,
                'kecamatan'         => $request->kecamatan_nama,
                'desa'                    => $request->Desa,
                'tanggal_tanam'          => Carbon::parse($request->Tanggal_Tanam)->format('Y-m-d'),
                'luas_lahan'             => (float) str_replace(',', '.', $request->Luas_Lahan),
                'harga_beli'      => (int) $request->Harga_Beli_Petani,
                'varietas_id'            => $varietas_id,
                'tanggal_panen'      => $response->json()['estimasi_tanggal_panen'],
                'umur_tanaman'      => $response->json()['umur_tanam'],
                "estimasi_biaya" => $response->json()['estimasi_pembayaran'],
                "mean_suhu" => $response->json()['suhu'],
                "mean_hujan" => $response->json()['curah_hujan'],
                'id_user' => auth()->user()->id,


                // 'prediksi_revenue'       => $response->json()['prediksi_revenue'],
                "estimasi_panen" => $response->json()['prediksi_panen_kg'],
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);
            Alert::success('Berhasil', 'Prediksi berhasil dilakukan');
            // dump(session('prediksi_input'));
            return redirect()->route('hasil_prediksi');

            /* ===============================
           4. RETURN RESPONSE ML
        ================================ */
        } catch (\Exception $e) {
            Alert::error('Gagal', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function detailHistory($id)
    {
        $detail = Prediksi::with('varietas')->findOrFail($id);
        $title = 'Detail History Prediksi';

        return view('detail_history', compact('title', 'detail'));
    }


    public function export(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        // 2. Parsing tanggal pakai Carbon
        $startDate = Carbon::parse($request->start_date)->format('Y-m-d');
        $endDate   = Carbon::parse($request->end_date)->format('Y-m-d');

        // 3. Nama file dinamis (standar report)
        $fileName = "Report_Histori_Prediksi_{$startDate}_sampai_{$endDate}.xlsx";

        // 4. Download Excel
        return Excel::download(
            new HistoriExport(
                $startDate // tetap format Y-m-d buat query
                ,
                $endDate,
                auth()->user()->name
            ),
            $fileName
        );
    }
}
