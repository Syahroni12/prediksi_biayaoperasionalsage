<?php

namespace App\Http\Controllers;

use App\Models\Prediksi;
use App\Models\User;
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

    public function profile()
    {
        $title = 'Profile';
        return view('profile', compact('title'));
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
        $histori = Prediksi::with('varietas')
            ->where('id_user', auth()->id())
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('desa', 'like', "%{$search}%")
                        ->orWhere('kecamatan', 'like', "%{$search}%")
                        ->orWhere('kabupaten', 'like', "%{$search}%")
                        ->orWhereHas('varietas', function ($q2) use ($search) {
                            $q2->where('varietas', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('history_prediksi', compact('title', 'histori'));
    }


    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),

        ]);

        $user = User::find(auth()->id());
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        Alert::success('Berhasil', 'Profile berhasil diperbarui');
        return redirect()->route('profile');
    }
}
