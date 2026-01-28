<?php

namespace App\Http\Controllers;

use App\Models\Prediksi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        $totalPrediksi = Prediksi::where('id_user', auth()->id())->count();

        $prediksiBulanIni = Prediksi::where('id_user', auth()->id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $prediksiTerakhir = Prediksi::with('varietas')
            ->where('id_user', auth()->id())
            ->latest()
            ->first();

        $riwayat = Prediksi::with('varietas')
            ->where('id_user', auth()->id())
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard', compact('title', 'totalPrediksi', 'prediksiBulanIni', 'prediksiTerakhir', 'riwayat'));
    }

    public function prediksi()
    {
        $title = 'Prediksi';
        return view('prediksi', compact('title'));
    }

    public function hasilPrediksi()
    {
        if (!session()->has('prediksi_result') || !session()->has('prediksi_input')) {
            Alert::error('Gagal', 'Anda belum melakukan prediksi');
            return redirect()->route('prediksi');
        }
        $title = 'Hasil Prediksi';
        $hasil_prediksi = session('prediksi_result');
        $input_data = session('prediksi_input');
        return view('hasil_prediksi', compact('title', 'hasil_prediksi', 'input_data'));
    }

    public function history(Request $request)
    {
        $search = $request->input('search');
        $title = 'History Prediksi';
        $histori = Prediksi::with('varietas')->where('id_user', auth()->user()->id)
            ->when($search, function ($query, $search) {
                return $query->where('desa', 'like', "%{$search}%")->orWhere('kecamatan', 'like', "%{$search}%")
                    ->orWhere('kabupaten', 'like', "%{$search}%")
                    ->orWhereHas('varietas', function ($query) use ($search) {
                        $query->where('varietas', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('history_prediksi', compact('title', 'histori'));
    }
}
